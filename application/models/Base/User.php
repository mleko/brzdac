<?php

/**
 *
 * @author mleko
 */
class Base_User extends Mleko_Model_ActiveRecord implements Zend_Acl_Role_Interface {

	protected static function provideModel($db = null, $table = null, $primaryKeyColumn = null) {
		$db = Base_Datastore::getMySQL();
		$table = 'user';
		$primaryKeyColumn = 'user_id';
		return parent::provideModel($db, $table, $primaryKeyColumn);
	}

	public function getRoleId() {
		return $this->role ? : 'guest';
	}

}
