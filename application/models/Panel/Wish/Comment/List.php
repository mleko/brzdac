<?php

/**
 *
 * @author mleko
 */
class Panel_Wish_Comment_List extends Mleko_Model_List {

	public function __construct() {
		$db = Base_Datastore::getMySQL();
		$select = $db->select()->from(array('root' => 'wish_comment'));
		parent::__construct($select);
	}

}
