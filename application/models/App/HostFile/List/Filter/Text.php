<?php

/**
 * Description of Text
 *
 * @author mleko
 */
class App_HostFile_List_Filter_Text implements App_Abstract_Filter {

	private $text;

	public function __construct($text) {
		$this->text = array_unique(explode(' ', strtolower($text)), SORT_STRING);
		sort($this->text, SORT_STRING);
	}

	public function Apply(\Zend_Db_Select &$select) {
		foreach ($this->text as $value) {
			$select->where('f.name LIKE ? OR d.path LIKE ?', '%'.$value.'%');
		}
	}

}

?>
