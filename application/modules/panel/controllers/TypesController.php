<?php

/**
 *
 * @author mleko
 */
class Panel_TypesController extends Panel_Controller_AuthorizedAction {

	public function indexAction() {

		if(!empty($_POST)) {
			foreach($_POST['name'] as $key => $type) {
				$extensions = explode(";", isset($_POST['extensions'][$key]) ? $_POST['extensions'][$key] : array());
				array_walk($extensions, function(&$ext) { $ext = trim($ext); });
				$extensions = array_filter($extensions, function($a) { return (bool) strlen($a); });
				array_walk($extensions, function(&$ext) { $ext = base_convert(trim($ext), 36, 10); });

				$fileType = new App_File_Type($key);
				if(!$key && !$type) { continue; }
				if(!$fileType->save(array('name' => $type))) { throw new Exception("Failed to create new file type"); }
				$fileType->saveExtensions($extensions);
			}
		}

		$list = new App_FileType_List(FALSE);

		$types = $list->GetData();

		$fileTypes = array();

		foreach($types as $type) {
			$fileType = new App_File_Type($type['id']);
			$extensionList = $fileType->getExtensions();
			array_walk($extensionList, function(&$ext) { $ext = base_convert($ext, 10, 36); });

			$fileTypes[] = array(
				'id' => $type['id'],
				'name' => $type['name'],
				'extensions' => implode(" ; ", $extensionList)
			);
		}
		$fileTypes[] = array();

		$this->view->fileTypes = $fileTypes;
	}

}
