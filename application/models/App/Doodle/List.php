<?php

/**
 * Description of List
 *
 * @author mleko
 */
class App_Doodle_List extends App_Abstract_List {

	public function __construct() {
		parent::__construct();
		$this->select->from(array('d' => 'doodle'))
				->join('doodle_file', 'd.file_id = doodle_file.id', array('name'));
	}

}

?>
