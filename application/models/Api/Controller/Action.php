<?php

/**
 *
 * @author mleko
 */
class Api_Controller_Action extends Zend_Controller_Action {

	public function preDispatch() {
		parent::preDispatch();
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_response->setHeader('Content-Type', 'application/json');
	}

}
