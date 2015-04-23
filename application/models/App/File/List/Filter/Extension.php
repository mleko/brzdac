<?php

/**
 * Description of Text
 *
 * @author mleko
 */
class App_File_List_Filter_Extension implements App_Abstract_Filter {

    /* NEED TO BE REWRITEN TO NEW DB MODEL */
	private $extensions;

	public function __construct($text) {
		$this->extensions = array_unique(explode(' ', strtolower($text)), SORT_STRING);
		sort($this->extensions, SORT_STRING);
	}

	public function Apply(\Zend_Db_Select &$select) {
		if (!$this->extensions)
			return;
		$select->where('f.extension IN (?)', $this->extensions);
	}

}

?>
