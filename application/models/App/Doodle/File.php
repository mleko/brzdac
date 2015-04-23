<?php

/**
 *
 * @author mleko
 */
class App_Doodle_File {
	public static function uploadFromPost($fileArray) {
		if(0 == $fileArray['size'] || 0 != $fileArray['error']) return false;

		$db = App_Datastore::getMySQL();

		$hash = md5($fileArray['name'] . $fileArray['tmp_name'] . time() . mt_rand());
		$name = $hash . substr($fileArray['name'], strpos($fileArray['name'], "."));

		$db->beginTransaction();
		$db->insert('doodle_file', array('name' => $name));
		$fileId = $db->lastInsertId();

		$filePath = APPLICATION_PATH . "/../public/img/doodle/" . $fileId . "-" . $name;

		if(FALSE === move_uploaded_file($fileArray['tmp_name'], $filePath)) {
			$db->rollBack();
			return FALSE;
		}
		$db->commit();
		return $fileId;
	}
}

?>
