<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Type
 *
 * @author mleko
 */
class App_File_Type {

	private $id_;

	public function __construct($id) {
		$this->id_ = $id;
	}

	public function save($data) {
		$db = App_Datastore::getMySQL();

		$bind = array(
			'name' => isset($data['name']) ? $data['name'] : ""
		);

		if($this->id_) {
			return FALSE !== $db->update('file_type', $bind, array('id = ?' => $this->id_));
		} else {
			if(FALSE === $db->insert('file_type', $bind)) return FALSE;
			$this->id_ = $db->lastInsertId();
			return TRUE;
		}
		return FALSE;
	}

	public function saveExtensions($array) {
		$list = $this->getExtensions();

		$toAdd = array();
		$toDelete = array();

		foreach($array as $ext) {
			if(!in_array($ext, $list)) {
				$toAdd[] = $ext;
			}
		}

		foreach($list as $ext) {
			if(!in_array($ext, $array)) {
				$toDelete[] = $ext;
			}
		}

		$db = App_Datastore::getMySQL();

		if($toDelete) $db->delete('file_type_extension', array('file_type_id = ?' => $this->id_, 'extension_int IN (?)' => $toDelete));

		if($toAdd) {
			foreach($toAdd as $ext) {
				$db->insert('file_type_extension', array('file_type_id' => $this->id_, 'extension_int' => $ext));
			}
		}
	}

	public function getExtensions() {
		if($this->id_) {
			$list = new App_File_Type_Extension_List();
			$list->Filter(new App_File_Type_Extension_List_Filter_FileType($this->id_));

			$data = $list->GetData();
			$exts = array();
			foreach($data as $value) {
				$exts[] = $value['extension_int'];
			}


			return $exts;
		}
		return array();
	}

}

?>
