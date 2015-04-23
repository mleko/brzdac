<?php

/**
 * Description of Host
 *
 * @author mleko
 */
class App_Host extends Mleko_Model_ActiveRecord {

	protected static function provideModel($db = null, $table = null, $primaryKeyColumn = null) {
		$db = App_Datastore::getMySQL();
		$table = 'host';
		$primaryKeyColumn = 'host';
		return parent::provideModel($db, $table, $primaryKeyColumn);
	}

	protected static $fields = array('shared');

	/* Semi fixed ;p */

	public static function GetOnlineCount() {
		$key = 'OnlineCount';

		$fetchMethod = function() {
			$db = App_Datastore::getMySQL();
			$select = $db->select()->from('host', array('count' => new Zend_Db_Expr('COUNT(host)')))
					->where('shared>0')
					->where('active=1')
					->where('last_activity_date > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
			return $count = $db->fetchOne($select); };

		return App_Abstract_RedisCache::get($key, $fetchMethod, 5 * 60);
	}

	public static function GetSharingCount() {
		$key = 'SharingCount';

		$fetchMethod = function() {
			$db = App_Datastore::getMySQL();
			$select = $db->select()->from('host', array('count' => new Zend_Db_Expr('COUNT(host)')))
					->where('shared>0');
			return $count = $db->fetchOne($select); };

		return App_Abstract_RedisCache::get($key, $fetchMethod, 5 * 60);
	}

	public static function GetKnownCount() {
		$key = 'KnownCount';

		$fetchMethod = function() {
			$db = App_Datastore::getMySQL();
			$select = $db->select()->from('host', array('count' => new Zend_Db_Expr('COUNT(host)')));
			return $count = $db->fetchOne($select); };

		return App_Abstract_RedisCache::get($key, $fetchMethod, 5 * 60);
	}

	public static function GetStat($lhost) {
		$db = App_Datastore::getMySQL();
		$select = $db->select()->from('host',
						array('last_file_scan_date' => new Zend_Db_Expr('UNIX_TIMESTAMP(last_file_scan_date)'),
					'last_activity_date' => new Zend_Db_Expr('UNIX_TIMESTAMP(last_activity_date)'),
					'active'))
				->where('host = ?');
		return $db->fetchRow($select, array($lhost));
	}

	public static function ShareList($min = NULL, $uptime = NULL, $blacklist = NULL) {
		$key = 'ShareList' . $min . '#' . $uptime . '#' . $blacklist;

		$val = App_Datastore::getRedis()->get($key);
		if($val !== FALSE) { return igbinary_unserialize($val); }
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = $db->select()->from(array('h' => 'host'), array('shared', 'host', 'blacklist'))
				->joinLeft(array('uptime' => 'v_host_uptime'), 'uptime.host = h.host', array('uptime' => 'uptime_ratio'))
				->where('shared > 0')
				->where('last_file_scan_date > (DATE_SUB(NOW(), INTERVAL 7 DAY))')
				->order('host ASC');
		if($blacklist) { $select->where('blacklist=0'); }
		if($min) { $select->where('shared>?', $min); }
		if($uptime) { $select->where('uptime_ratio > ?', $uptime); }
		$share = $db->fetchAll($select);
		if(FALSE !== $share) { App_Datastore::getRedis()->setex($key, 2 * 60 * 60, igbinary_serialize($share)); }
		return $share;
	}

	public static function GetUptimeList($host = NULL, $weeks = 3) {
		if($host === NULL) { $host = ip2long($_SERVER['REMOTE_ADDR']); }
		$key = 'UTL_' . $weeks . '#' . $host;

		$val = App_Datastore::getRedis()->get($key);
		if($val !== FALSE) { return igbinary_unserialize($val); }
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = $db->select()->from('host_uptime',
						array('ratio' => new Zend_Db_Expr('SUM(active=1)/COUNT(1)'), 'dow' => new Zend_Db_Expr('WEEKDAY(timestamp)'), 'hour' => new Zend_Db_Expr('HOUR(timestamp)')))
				->where('host = ?', $host)
				->where('NOW() <= DATE_ADD(timestamp, INTERVAL ? WEEK)', $weeks)
				->group('WEEKDAY(timestamp)')
				->group('HOUR(timestamp)');
		$UL = $db->fetchAll($select);
		if(FALSE !== $UL) { App_Datastore::getRedis()->setex($key, 60 * 60, igbinary_serialize($UL)); }
		return $UL;
	}

	/* Old stuff, to be rewritten sometime to some decent structure */

	public static function GetShares($host = NULL) {
		if($host === NULL) { $host = ip2long($_SERVER['REMOTE_ADDR']); }
		$key = 'HS_' . $host;

		$val = App_Datastore::getRedis()->get($key);
		if($val !== FALSE) { return $val; }
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = $db->select()->from('host', array('shared'))
				->where('host = ?', $host);
		$share = $db->fetchOne($select);
		if(FALSE !== $share) { App_Datastore::getRedis()->setex($key, 3600, $share); }
		return $share;
	}

	public static function BlackList() {
		$key = 'BlackList';

		$val = App_Datastore::getRedis()->get($key);
		if($val !== FALSE) { return igbinary_unserialize($val); }
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = $db->select()->from('host', array('host'))
				->where('blacklist=1')
				->order('host ASC');
		$share = $db->fetchAll($select);
		if(FALSE !== $share) { App_Datastore::getRedis()->setex($key, 2 * 60 * 60, igbinary_serialize($share)); }
		return $share;
	}

	public static function Add($ip = NULL) {
		if($ip === NULL) { $ip = $_SERVER['REMOTE_ADDR']; }
		if(substr_compare($ip, '10.', 0, 3)) { return; }

		$ip = ip2long($ip);

		$db = App_Datastore::getMySQL();
		$select = $db->select()->from('host', array('host'))->where('host = ?', $ip);
		if(FALSE === $db->fetchRow($select)) {
			$db->insert('host', array('host' => $ip, 'last_activity_date' => new Zend_Db_Expr('NOW()')));
		}
	}

}
