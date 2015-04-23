<?php

/**
 *
 * @author mleko
 */
class Panel_Wish extends Mleko_Model_ActiveRecord {

	protected static function provideModel($db = null, $table = null, $primaryKeyColumn = null) {
		$db = App_Datastore::getMySQL();
		$table = 'wish';
		$primaryKeyColumn = 'wish_id';
		return parent::provideModel($db, $table, $primaryKeyColumn);
	}

	protected static $fields = array('host', 'creation_date', 'text', 'status', 'user_id');

}
