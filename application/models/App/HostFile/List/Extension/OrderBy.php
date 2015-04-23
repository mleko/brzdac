<?php

/**
 * Description of OrderBy
 *
 * @author mleko
 */
class App_HostFile_List_Extension_OrderBy extends App_Abstract_ListOrderBy {

	protected static $binds = array(
		'file_id' => 'f.id',
		'host' => 'h.host',
		'file' => 'h.file_id',
		'dir_name' => 'd.path',
		'file_name' => 'f.name',
		'activity' => 'h.active',
		'activity_date' => 'h.last_activity_date'
	);

}
