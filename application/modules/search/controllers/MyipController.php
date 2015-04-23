<?php

class Search_MyipController extends Zend_Controller_Action {

    public function init() {
	/* Initialize action controller here */
    }

    public function indexAction() {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_response->setBody($_SERVER['REMOTE_ADDR']);
    }


}

