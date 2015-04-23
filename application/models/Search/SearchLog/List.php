<?php

/**
 *
 * @author mleko
 */
class Search_SearchLog_List extends Mleko_Model_List {

	public function __construct() {
		$db = Base_Datastore::getMySQL();
		$select = $db->select()->from(array('root' => 'search_visit_log'));
		parent::__construct($select, $fetchData);
	}

}
