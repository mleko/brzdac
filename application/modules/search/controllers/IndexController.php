<?php

class Search_IndexController extends Zend_Controller_Action {

	public function indexAction() {
		$this->_forward('angular');
	}

	public function angularAction() {
		$host = App_Host::get(ip2long($_SERVER['REMOTE_ADDR']));
		if($host->host == FALSE) { App_Host::Add(); }
		App_Log_SearchVisit::log($_SERVER['REMOTE_ADDR']);
	}

}
