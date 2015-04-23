<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecentSearch
 *
 * @author mleko
 */
class App_RecentSearch {

	/**
	 * @var Redis
	 */
	public static $redis = NULL;

	public static function Push($text, $type) {
		if(!$text) { return; }
		if(static::$redis === NULL) { static::$redis = App_Datastore::getRedis(); }
		$value = igbinary_serialize(array('text' => $text, 'type' => $type));
		static::$redis->lRem('RecentSearch', $value, 2);
		static::$redis->lPush('RecentSearch', $value);
		static::$redis->lTrim('RecentSearch', 0, 10);
	}

	public static function Get() {
		$ret = array();
		try {
			if(static::$redis === NULL) { static::$redis = App_Datastore::getRedis(); }
			$search = static::$redis->lGetRange('RecentSearch', 0, 10);

			foreach($search as $value) {
				$ret[] = igbinary_unserialize($value);
			}
		} catch(Exception $ex) {

		}
		return $ret;
	}

}

?>
