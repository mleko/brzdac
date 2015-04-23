<?php

/**
 * Description of OrderBy
 *
 * @author mleko
 */
class App_File_List_Extension_OrderBy extends App_Abstract_ListOrderBy{
	protected static $binds = array(
		'file_id' => 'f.id',
		'file_name' => 'f.name'
	);
}

?>
