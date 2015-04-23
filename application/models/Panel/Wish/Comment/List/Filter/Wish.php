<?php

/**
 *
 * @author mleko
 */
class Panel_Wish_Comment_List_Filter_Wish extends Mleko_Model_List_Filter {

	private $wishId;

	public function __construct($wish) {
		if($wish instanceof Panel_Wish) {
			$this->wishId = $wish->wishId;
		} else {
			$this->wishId = intval($wish);
		}
	}

	public function apply(\Zend_Db_Select $select) {
		$select->where('root.wish_id = ?', $this->wishId);
	}

}
