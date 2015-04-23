<?php

/**
 * Description of List
 *
 * @author mleko
 */
class App_File_List extends App_Abstract_CachedList {

	public function __construct($key_prefix = 'FL_', $cache_expiration_time = 900) {
		parent::__construct($key_prefix, $cache_expiration_time);
		$this->select->from(array('f' => 'file'), array('name'));
	}

}

?>
