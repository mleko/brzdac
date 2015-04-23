<?php

/**
 *
 * @author mleko
 */
class Base_Identity {

	const SALT = '#smieszniePosoloneHasloDlaBrzdaca_ranugruy4wgxw4mgxr4i';

	private static $user = null;

	public static function authenticate($login, $password) {
		if(null != $login && null != $password) {
			$adapter = self::getAuthAdapter();
			$adapter->setIdentity($login);
			$adapter->setCredential($password);

			$result = $adapter->authenticate();
			if($result->isValid()) {
				$row = $adapter->getResultRowObject();
				$auth = Zend_Auth::getInstance();
				$auth->getStorage()->write($row->user_id);
				static::$user = null;
				return true;
			}
		}
		return false;
	}

	public static function logout() {
		self::$user = null;
		Zend_Auth::getInstance()->clearIdentity();
		Zend_Session::forgetMe();
		Zend_Session::destroy();
	}

	/**
	 *
	 * @return Base_User
	 */
	public static function getInstance() {
		if(NULL === self::$user) {
			$auth = Zend_Auth::getInstance();
			$user = Base_User::get($auth->getIdentity());
			self::$user = $user;
		}
		return self::$user;
	}

	private static function getAuthAdapter() {
		$db = Base_Datastore::getMySQL();
		return new Zend_Auth_Adapter_DbTable($db, 'user', 'login', 'password', 'SHA1(CONCAT(?,salt,' . $db->quote(self::SALT) . '))');
	}

}
