<?php

/**
 * Description of File
 *
 * @author mleko
 */
class App_File {

    public static function GetID($file) {

	if (strlen($file['name']) > 140)
	    return NULL;

	$db = Zend_Db_Table::getDefaultAdapter();

	$select = $db->select()->from('file', array('id'))
		->where('name = ?', $file['name'])
		->where('size = ?', $file['size']);

	$fid = $db->fetchOne($select);
	if ($fid)
	    return $fid;

	$extension = strtolower(substr(strrchr($file['name'], '.'), 1));

	if (strlen($extension) <= 4)
	    $extension = base_convert($extension, 36, 10);
	else
	    $extension = NULL;

	try {
	    $bind = array(
		'name' => $file['name'],
		'size' => $file['size'],
		'extension_int' => $extension
	    );
	    if (FALSE === $db->insert('file', $bind))
		return FALSE;
	} catch (Exception $e) {
	    Mleko_Log::err($e->getMessage());
	    return FALSE;
	}
	return $db->lastInsertId();
    }

}

?>
