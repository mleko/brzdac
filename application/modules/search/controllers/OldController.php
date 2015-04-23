<?php

class Search_OldController extends Zend_Controller_Action {

	public function preDispatch() {
		parent::preDispatch();

		$file_type_list = new App_FileType_List();
		$file_type_result = $file_type_list->GetData();

		$file_types = array(0 => 'Wszystko');
		foreach($file_type_result as $ftr) {
			$file_types[$ftr['id']] = $ftr['name'];
		}

		$this->view->type_options = $file_types;

		$host = App_Host::get(ip2long($_SERVER['REMOTE_ADDR']));

		$shares = $host->shared;
		$this->view->shares = (int) $shares;
		if($host->host == FALSE) { App_Host::Add(); }
		$this->view->onlineCount = (int) App_Host::GetOnlineCount();
		$this->view->sharingCount = (int) App_Host::GetSharingCount();
		$this->view->knownCount = (int) App_Host::GetKnownCount();
	}

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		_D('controler start');
		if(!empty($_GET) && isset($_GET['text'])) {
			$this->_forward('search');
		} else {
			$this->_forward('splash');
		}
	}

	public function splashAction() {
		$searches = App_RecentSearch::Get();
		$this->view->searches = $searches;

		$file_list = new App_HostFile_List('LAFL_', 1800);
		$file_list->Filter(new App_File_List_Filter_FileType(1));
		$file_list->Filter(new App_HostFile_List_Filter_Size(1024 * 1024 * 300));
		$file_list->Limit(11);
		$file_list->Order(new App_File_List_Extension_OrderBy('file_id', 'DESC'));

		$this->view->new_movies = $file_list->GetData();

		App_Log_SearchVisit::log($_SERVER['REMOTE_ADDR']);

		if(($doodle = App_Doodle::getDoodle($this->_getParam('debug_doodle')))) {
			$this->view->doodle = $doodle;
		}
	}

	public function searchAction() {
		$text = trim((isset($_GET['text']) ? $_GET['text'] : ""));
		$sphinx = substr($text, 0, 1) != '!';
		if(!$sphinx) { $text = substr($text, 1); }
		$text = trim($text);

		$type = intval((isset($_GET['type']) ? $_GET['type'] : 0));

		$data = $sphinx ? $this->sphinxSearch_($text, $type) : $this->likeSearch_($text, $type);

		App_Log_SearchVisit::log($_SERVER['REMOTE_ADDR'], $text, $type, count($data));

		if(count($data) && !isset($_GET['hide']) && $type != 'all') {
			if(3 < max(array_map('strlen', explode(' ', $text)))) { App_RecentSearch::Push($text, $type); }
		}

		$this->view->files = $this->groupHost($data);
	}

	private function likeSearch_($text = NULL, $type = NULL) {
		$file_list = new App_HostFile_List();

		if($text) { $file_list->Filter(new App_HostFile_List_Filter_Text($text)); }

		$file_list->Filter(new App_HostFile_List_Filter_FileType($type));

		$file_list->Order(new App_HostFile_List_Extension_OrderBy('activity', 'DESC'));
		$file_list->Order(new App_HostFile_List_Extension_OrderBy('activity_date', 'DESC'));
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
		$fileList->Order(new App_HostFile_List_Extension_OrderBy('activity_date', 'DESC'));
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
				$active = $file['active'] && (time() - $file['last_activity_date']) < (30 * 60);

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
