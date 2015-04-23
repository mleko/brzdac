<?php

/**
 *
 * @author mleko
 */
class Panel_AuthController extends Zend_Controller_Action {

	public function loginAction() {
		$this->_forward('index');
	}

	public function indexAction() {
		if(Base_Identity::authenticate($this->_getParam('login'), $this->_getParam('pass'))) {
			$this->_redirect("/panel");
		}
	}

	public function logoutAction() {
		Base_Identity::logout();
		$this->_redirect('/panel');
	}

}
