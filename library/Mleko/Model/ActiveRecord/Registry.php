<?php

/**
 *
 * @author mleko
 */
class Mleko_Model_ActiveRecord_Registry {

	static $registry;

	static public function get($className, $pkVal) {
		if(isset(static::$registry[$className][$pkVal])) { return static::$registry[$className][$pkVal]; }
		return null;
	}

	static public function set($className, $pkVal, Mleko_Model_ActiveRecord & $object) {

		static::$registry[$className][$pkVal] = $object;
	}

}

?>
