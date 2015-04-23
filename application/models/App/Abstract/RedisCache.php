<?php

/**
 *
 * @author mleko
 */
class App_Abstract_RedisCache {

	static public function get($key, $fetchMethod, $ttl = null, $throwException = false) {
		$redis = App_Datastore::getRedis();
		try {
			$value = $redis->get($key);
			if(false !== $value) { return igbinary_unserialize($value); }
		} catch(Exception $ex) {
			if($throwException) { throw $ex; }
		}

		$value = $fetchMethod();

		try {
			if(null == $ttl) {
				$redis->set($key, igbinary_serialize($value));
			} else {
				$redis->setex($key, $ttl, igbinary_serialize($value));
			}
		} catch(Exception $ex) {
			if($throwException) { throw $ex; }
		}
		return $value;
	}

}
