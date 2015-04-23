<?php

/**
 *
 * @author mleko
 */
class Api_DoodleController extends Api_Controller_Action {

	public function preDispatch() {
		parent::preDispatch();
		$format = 'D, d M Y H:i:s T';
		$this->_response->setHeader('Expires', date($format, time() + 60 * 60));
	}

	public function indexAction() {
		$doodle = App_Doodle::getDoodle($this->_getParam('debug_doodle'));
		if($doodle) {
			echo Zend_Json::encode(array(
				'file_id' => $doodle['file_id'],
				'name' => $doodle['name'],
				'description' => $doodle['description']
			));
		} else {
			echo Zend_Json::encode(array('file_id' => 0));
		}
	}

}
