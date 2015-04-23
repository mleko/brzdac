<?php

/**
 * Description of List
 *
 * @author mleko
 */
class App_HostFile_List extends App_Abstract_List {

	public function __construct($key_prefix = 'FL_', $cache_expiration_time = 900) {
		parent::__construct($key_prefix, $cache_expiration_time);
		$this->select->from(array('hf' => 'host_file'), array('host', 'file_id', 'size'))
				->join(array('f' => 'file'), 'f.id=hf.file_id', array('name'))
				->join(array('d' => 'directory'), 'd.id=hf.directory_id', array('path'))
				->join(array('h' => 'host'), 'h.host=hf.host',
						array('active', 'last_activity_date' => new Zend_Db_Expr('UNIX_TIMESTAMP(last_activity_date)')));
	}

}

?>
