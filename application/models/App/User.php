<?php

/**
 *
 * @author mleko
 */
class App_User {

	const SALT = 'smieszniePosoloneHasloDlaBrzdaca_ranugruy4wgxw4mgxr4i';

	static function isAuthorized($priv) {
		$session = new Zend_Session_Namespace('auth');
		if(!isset($session->$priv)) return FALSE;

		if($priv == 'panel') {
			$allowedIps = array('127.0.0.1', '10.5.0.131', '10.5.1.143');
			$clientIp = $_SERVER['REMOTE_ADDR'];
			if(!in_array($clientIp, $allowedIps)) {
				return FALSE;
			}
		}
		return TRUE;
	}

	static function login($user, $pass) {
		$users = array(
			'mleko' => array('pass' => 'b2a388e213dbb17519f527cd61fc06771955d6f4', 'privs' => array('panel')),
			'brzdac' => array('pass' => '0aeab337cde431b31cf782ff414540c2e0cb14c3', 'privs' => array('panel'))
		);
		if(!array_key_exists($user, $users)) return FALSE;
		if($users[$user]['pass'] != sha1(self::SALT . $pass)) return FALSE;
		$session = new Zend_Session_Namespace('auth');
		foreach($users[$user]['privs'] as $prv) {
			$session->$prv = 1;
		}
		return TRUE;
	}

	static function logout() {
		$session = new Zend_Session_Namespace('auth');
		$session->unsetAll();
		Zend_Session::destroy(true);
	}

}

?>
