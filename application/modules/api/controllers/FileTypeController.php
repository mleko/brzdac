<?php

/**
 *
 * @author mleko
 */
class Api_FileTypeController extends Api_Controller_Action {

	public function preDispatch() {
		parent::preDispatch();
		$format = 'D, d M Y H:i:s T';
		$this->_response->setHeader('Expires', date($format, time() + 60 * 60));
	}

	public function indexAction() {
		$file_type_list = new App_FileType_List();
		$file_type_result = $file_type_list->GetData();

		$file_types = array(array('id' => 0, 'name' => 'Wszystko'));
		foreach($file_type_result as $ftr) {
			$file_types[] = array('id' => $ftr['id'], 'name' => $ftr['name']);
		}

		echo Zend_Json::encode($file_types);
	}

}
