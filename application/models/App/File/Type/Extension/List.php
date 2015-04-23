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
class App_File_Type_Extension_List extends App_Abstract_CachedList{
    public function __construct() {
	parent::__construct('FileTypeExteList_', 1);
	$this->select->from( array("fte" => 'file_type_extension'), array('fte.extension_int'));
    }
}
?>
