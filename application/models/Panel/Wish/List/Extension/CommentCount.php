<?php

/**
 *
 * @author mleko
 */
class Panel_Wish_List_Extension_CommentCount extends Mleko_Model_List_Extension {

	public function join(\Zend_Db_Select $select, $fetchData = true) {
		$select->joinLeft(array('wcC' => 'wish_comment'), 'root.wish_id = wcC.wish_id',
						array('commentCount' => new Zend_Db_Expr('COUNT(wcC.comment_id)')))
				->group('root.wish_id');
	}

}
