<?php

/**
 * Description of Text
 *
 * @author mleko
 */
class App_HostFile_List_Filter_Size implements App_Abstract_Filter {

	private $min;
	private $max;

	public function __construct($min = NULL, $max = NULL) {
		$this->min = $min;
		$this->max = $max;
	}

	public function Apply(\Zend_Db_Select &$select) {
		if($this->min != NULL) {
			$select->where('hf.size >= ?', $this->min); }
		if($this->max != NULL) {
			$select->where('hf.size <= ?', $this->max); }
	}

}

?>
