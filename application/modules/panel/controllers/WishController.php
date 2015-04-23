<?php

/**
 *
 * @author mleko
 */
class Panel_WishController extends Panel_Controller_Action {

	public function indexAction() {
		if(false != ($input = filter_input_array(INPUT_POST, array('wish' => FILTER_SANITIZE_STRING))) &&
				false != ($ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP))) {
			$wish = Panel_Wish::get();
			$wish->text = $input['wish'];
			$wish->userId = Base_Identity::getInstance()->userId;
			$wish->creationDate = new Zend_Db_Expr('NOW()');
			$wish->host = ip2long($ip);

			$wish->save();
		}

		$wishCollection = new Panel_Wish_List();
		$wishCollection->addExtension(new Panel_Wish_List_Extension_CommentCount());
		$objects = $wishCollection->getArray();
		$array = array();
		foreach($objects as $wish) {
			$array[] = array(
				'wishId' => $wish['wish_id'],
				'wish' => $wish['text'],
				'ip' => long2ip($wish['host']),
				'user' => Base_User::get($wish['user_id'])->login,
				'date' => $wish['creation_date'],
				'commentCount' => $wish['commentCount']
			);
		}
		$this->view->wishes = $array;
	}

	public function detailsAction() {
		$wish = Panel_Wish::get($this->_getParam('key'));

		if(false != ($input = filter_input_array(INPUT_POST, array('comment' => FILTER_SANITIZE_STRING))) &&
				false != ($ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP))) {
			$comment = Panel_Wish_Comment::get();
			$comment->wishId = $wish->wishId;
			$comment->text = $input['comment'];
			$comment->userId = Base_Identity::getInstance()->userId;
			$comment->host = ip2long($ip);

			$comment->save();
		}

		$this->view->wish = array(
			'wish' => $wish->text,
			'ip' => long2ip($wish->host),
			'user' => Base_User::get($wish->userId)->login,
			'date' => $wish->creationDate
		);
		$commentList = new Panel_Wish_Comment_List();
		$commentList->addFilter(new Panel_Wish_Comment_List_Filter_Wish($wish));

		$commentArray = array();
		foreach($commentList->getResult() as $row) {
			$commentArray[] = array(
				'text' => $row['text'],
				'user' => Base_User::get($row['user_id'])->login,
				'ip' => long2ip($row['host'])
			);
		}

		$this->view->comments = $commentArray;
	}

}
