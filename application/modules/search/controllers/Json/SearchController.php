<?php

class Search_Json_SearchController extends Zend_Controller_Action {

	public function preDispatch() {
		parent::preDispatch();
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_response->setHeader('Content-Type', 'application/json');
	}

	public function indexAction() {
		$this->_forward('search');
	}

	public function searchAction() {
		$text = (isset($_GET['text']) ? $_GET['text'] : "");
		$sphinx = substr($text, 0, 1) != '!';
		if(!$sphinx) $text = substr($text, 1);
		$text = trim($text);

		$type = intval((isset($_GET['type']) ? $_GET['type'] : 0));

		$data = $sphinx ? $this->sphinxSearch_($text, $type) : $this->likeSearch_($text, $type);

		App_Log_SearchVisit::log($_SERVER['REMOTE_ADDR'], $text, $type);

		if(count($data) && !isset($_GET['hide']) && $type != 'all') {
			if(3 < max(array_map('strlen', explode(' ', $text)))) App_RecentSearch::Push($text, $type);
		}

		$ret = array('items' => $this->groupHost($data));

		$this->_response->setBody(json_encode($ret));
	}

	private function likeSearch_($text = NULL, $type = NULL) {
		$file_list = new App_HostFile_List();

		if($text) $file_list->Filter(new App_HostFile_List_Filter_Text($text));

		$file_list->Filter(new App_HostFile_List_Filter_FileType($type));

		$file_list->Order(new App_HostFile_List_Extension_OrderBy('activity', 'DESC'));
		$file_list->Order(new App_HostFile_List_Extension_OrderBy('scan_time', 'DESC'));
		$file_list->Order(new App_HostFile_List_Extension_OrderBy('host', 'ASC'));
		$file_list->Order(new App_HostFile_List_Extension_OrderBy('dir_name', 'ASC'));
		$file_list->Order(new App_HostFile_List_Extension_OrderBy('file_name', 'ASC'));

		$file_list->Limit(1000);

		Mleko_Log::dbg($file_list->Log());

		return $file_list->GetData();
	}

	private function sphinxSearch_($text, $type) {
		$fileList = new App_HostFile_List();

		$fileType = new App_File_Type($type);
		$extensions = $fileType->getExtensions();

		$ids = App_File_Index::fetchIds($text, $extensions);

		$fileList->Filter(new App_HostFile_List_Filter_Id($ids));

		$fileList->Order(new App_HostFile_List_Extension_OrderBy('activity', 'DESC'));
		$fileList->Order(new App_HostFile_List_Extension_OrderBy('scan_time', 'DESC'));
		$fileList->Order(new App_HostFile_List_Extension_OrderBy('host', 'ASC'));
		$fileList->Order(new App_HostFile_List_Extension_OrderBy('dir_name', 'ASC'));
		$fileList->Order(new App_HostFile_List_Extension_OrderBy('file_name', 'ASC'));

		return $fileList->GetData();
	}

	private function groupHost($data) {
		$set = array();
		$host = 0;
		$groupNumber = 0;
		$active = 0;

		foreach($data as $file) {
			if($host != $file['host']) {
				$host = $file['host'];
				$groupNumber++;
				$active = $file['active'] && (time() - $file['last_activity_scan_date']) < (30 * 60);

				$set[$groupNumber]['header'] = long2ip($host);
				$set[$groupNumber]['active'] = $active;
			}
			$set[$groupNumber]['files'][] = array(
				'host' => long2ip($file['host']),
				'path' => $file['path'],
				'name' => $file['name'],
				'size' => $file['size'],
				'active' => $active
			);
		}
		return $set;
	}

}

