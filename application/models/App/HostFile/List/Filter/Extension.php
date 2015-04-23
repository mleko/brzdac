<?php

/**
 * Description of Text
 *
 * @author mleko
 */
class App_HostFile_List_Filter_Extension implements App_Abstract_Filter {

	private $extensions;

	public function __construct($text) {
		$this->extensions = array_unique(explode(' ', strtolower($text)), SORT_STRING);
		sort($this->extensions, SORT_STRING);
	}

	public function Apply(\Zend_Db_Select &$select) {
		if (!$this->extensions)
			return;
		$db = Zend_Db_Table::getDefaultAdapter();
		$select->where('f.extension IN (?)', $this->extensions);
	}

}

?>
