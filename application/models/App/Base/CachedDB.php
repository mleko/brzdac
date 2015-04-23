<?php

/**
 * Description of CachedDB
 *
 * @author mleko
 */
abstract class App_Base_CachedDB extends Zend_Db_Adapter_Abstract{
	/**
	 * @var Redis
	 */
	private $redis;
	protected $cache_expiration_time = 900; // 15 minutes
	public $cache_used = FALSE;	
	
	public function fetchAll($sql, $bind = array(), $fetchMode = null) {
		$this->redis = App_Datastore::getRedis();
		$key = $this->select->__toString();
		//$key = 'SELECT';
		$key = sha1($key) . md5($key);
		$val = $this->redis->get($key);
		$this->cache_used = $val !== FALSE;
		if ($val !== FALSE)
			return igbinary_unserialize($val);
		$value = parent::GetData();
		$this->redis->setex($key, $this->cache_expiration_time, igbinary_serialize($value));
		return $value;
		
		parent::fetchAll($sql, $bind, $fetchMode);
	}
}

?>
