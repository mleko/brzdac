<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Filter
 *
 * @author mleko
 */
class App_File_Type_Extension_List_Filter_FileType implements App_Abstract_Filter {
    
    private $file_type_id_ = FALSE;
    
    public function __construct($file_type) {
	$this->file_type_id_ = intval($file_type);
    }
    
    public function Apply(\Zend_Db_Select &$select) {
	$select->where('fte.file_type_id = ?', $this->file_type_id_);
    }
}

?>
