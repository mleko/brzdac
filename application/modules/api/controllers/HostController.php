<?php

/**
 *
 * @author mleko
 */
class Api_HostController extends Api_Controller_Action {

	public function preDispatch() {
		parent::preDispatch();
		$format = 'D, d M Y H:i:s T';
		$this->_response->setHeader('Expires', date($format, time() + 5 * 60));
	}

	public function statAction() {
		$stat = array(
			'online' => (int) App_Host::GetOnlineCount(),
			'sharing' => (int) App_Host::GetSharingCount(),
			'known' => (int) App_Host::GetKnownCount()
		);

		echo Zend_Json::encode($stat);
	}

}
