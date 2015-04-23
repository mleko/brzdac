<?php

/**
 * Description of Text
 *
 * @author mleko
 */
class App_File_List_Filter_FileType implements App_Abstract_Filter {

    private $file_type_id;

    public function __construct($file_type_id) {
	$this->file_type_id = $file_type_id;
    }

    public function Apply(\Zend_Db_Select &$select) {
	if ($this->file_type_id)
	    $select->join(array('ffft_fte' => 'file_type_extension'), 'ffft_fte.extension_int = f.extension_int', array())
		    ->where('ffft_fte.file_type_id = ?', $this->file_type_id);
    }

}

?>
