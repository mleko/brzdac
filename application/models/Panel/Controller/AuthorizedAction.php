<?php

/**
 *
 * @author mleko
 */
class Panel_Controller_AuthorizedAction extends Panel_Controller_Action {

	public function preDispatch() {
		parent::preDispatch();

		if(!Base_Identity::getInstance()->userId) {
			$this->_forward('login', 'auth');
			return;
		}
	}

}
