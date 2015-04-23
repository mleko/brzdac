<?php

/**
 *
 * @author mleko
 */
abstract class Base_Acl {

	static private $acl = NULL;

	static public function init(Zend_Acl $acl) {
		self::$acl = $acl;
	}

	/**
	 *
	 * @return Zend_Acl
	 * @throws Exception
	 */
	static public function get() {
		if(null === self::$acl) { throw new Exception("Acl must be initialized first"); }
		return self::$acl;
	}

	/**
	 * @param  Zend_Acl_Role_Interface|string     $role
	 * @param  Zend_Acl_Resource_Interface|string $resource
	 * @param  string                             $privilege
	 * @return boolean
	 */
	static public function isAllowed($resource = NULL, $privilege = NULL, $role = NULL) {
		if(null === $role) { $role = Base_Identity::getInstance(); }
		if(false === $role) { return false; }
		return self::get()->isAllowed($role, $resource, $privilege);
	}

}
