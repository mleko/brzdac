<?php

class Api_SearchController extends Api_Controller_Action {
	public function preDispatch() {
		parent::preDispatch();
	}
	public function indexAction() {
		$text = $this->_getParam('text');
		$type = intval($this->_getParam('type'));

		$fileList = new App_HostFile_List();

		$fileType = new App_File_Type($type);
		$extensions = $fileType->getExtensions();

		$ids = App_File_Index::fetchIds($text, $extensions);

		$fileList->Filter(new App_HostFile_List_Filter_Id($ids));

		$fileList->Order(new App_HostFile_List_Extension_OrderBy('activity', 'DESC'));
		$fileList->Order(new App_HostFile_List_Extension_OrderBy('activity_date', 'DESC'));

		$data = $fileList->GetData();

		App_Log_SearchVisit::log($_SERVER['REMOTE_ADDR'], $text, $type, count($data));

		if(count($data) && !isset($_GET['hide']) && $type != 'all') {
			if(3 < max(array_map('strlen', explode(' ', $text)))) { App_RecentSearch::Push($text, $type); }
		}
		$format = 'D, d M Y H:i:s T';
		$this->_response->setHeader('Expires', date($format, time() + 10 * 60));
		echo Zend_Json::encode($data);
	}
	public function recentAction() {
		$searches = App_RecentSearch::Get();
		echo Zend_Json::encode($searches);
	}
	public function lastFoundAction() {
		$file_list = new App_HostFile_List('LAFL_', 1800);
		$file_list->Filter(new App_File_List_Filter_FileType(1));
		$file_list->Filter(new App_HostFile_List_Filter_Size(1024 * 1024 * 300));
		$file_list->Limit(11);
		$file_list->Order(new App_File_List_Extension_OrderBy('file_id', 'DESC'));
		$format = 'D, d M Y H:i:s T';
		$this->_response->setHeader('Expires', date($format, time() + 30 * 60));
		echo Zend_Json::encode($file_list->GetData());
	}
}
