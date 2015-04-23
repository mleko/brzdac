<?php

/**
 *
 * @author mleko
 */
class App_Abstract_Controller_Panel extends Zend_Controller_Action {

	public function preDispatch() {
		parent::preDispatch();

		if(!App_User::isAuthorized('panel')) {
			$this->_forward('login', 'auth');
			return;
		}
	}

}
?>
