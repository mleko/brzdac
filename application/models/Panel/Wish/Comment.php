<?php

/**
 *
 * @author mleko
 */
class Panel_Wish_Comment extends Mleko_Model_ActiveRecord {

	protected static function provideModel($db = null, $table = null, $primaryKeyColumn = null) {
		$db = App_Datastore::getMySQL();
		$table = 'wish_comment';
		$primaryKeyColumn = 'comment_id';
		return parent::provideModel($db, $table, $primaryKeyColumn);
	}

	protected static $fields = array('wish_id', 'host', 'user_id', 'text');

}
