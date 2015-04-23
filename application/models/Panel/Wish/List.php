<?php

/**
 *
 * @author mleko
 */
class Panel_Wish_List extends Mleko_Model_List {

	public function __construct() {
		$db = Base_Datastore::getMySQL();
		$select = $db->select()->from(array('root' => 'wish'));
		parent::__construct($select);
	}

}
