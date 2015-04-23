<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of List
 *
 * @author mleko
 */
class App_FileType_List extends App_Abstract_CachedList {

	public function __construct($useCache = TRUE) {
		parent::__construct('FileTypeList_', 6000);
		$this->useCache = $useCache;
		$this->select->from(array('ft' => 'file_type'), array('name', 'id'));
	}

}

?>
