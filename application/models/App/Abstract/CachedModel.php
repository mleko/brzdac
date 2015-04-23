<?php

/**
 *
 * @author mleko
 */
abstract class App_Abstract_CachedModel extends Mleko_Model_ActiveRecord {

	protected function getCached($key, $fetchMethod, $ttl = null) {
		try { $redis = App_Datastore::getRedis();
			$val = $redis->get($key);
			if(false !== $val) { return $val; }
		} catch(Exception $e) {

		}

		$value = $fetchMethod();
		try {
			if(null === $ttl) {
				$redis->set($key, $value);
			} else {
				$redis->setex($key, $ttl, $value);
			}
		} catch(Exception $e) {

		}
	}

}
