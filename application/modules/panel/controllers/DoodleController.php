<?php

/**
 *
 * @author mleko
 */
class Panel_DoodleController extends Panel_Controller_AuthorizedAction {

	public function editAction() {
		$this->_forward('index');
	}

	public function enableAction() {
		if($this->_getParam('key')) {
			$doodle = new App_Doodle($this->_getParam('key'));
			$doodle->save(array('enabled' => 1));
		}
		$this->_forward('index');
	}

	public function disableAction() {
		if($this->_getParam('key')) {
			$doodle = new App_Doodle($this->_getParam('key'));
			$doodle->save(array('enabled' => 0));
		}
		$this->_forward('index');
	}

	public function indexAction() {
		$doodleList = new App_Doodle_List();

		if($this->_getParam('key')) {
			$doodle = new App_Doodle($this->_getParam('key'));
			$edit = $doodle->data();
			$this->view->edit = $edit;
		}

		if(isset($_POST) && !empty($_POST)) {
			$fileId = 0;
			if(isset($_FILES) && isset($_FILES['file'])) {
				$file = $_FILES['file'];
				$fileId = App_Doodle_File::uploadFromPost($file);
			}

			$doodleId = isset($_POST['doodle_id']) ? $_POST['doodle_id'] : 0;
			$doodle = new App_Doodle($doodleId);
			$data = $_POST;
			$data['enabled'] = 0;
			if($fileId) $data['file_id'] = $fileId;
			$doodle->save($data);
		}

		$this->view->doodles = $doodleList->GetData();
	}

}

?>
