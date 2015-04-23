<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author mleko
 */
class App_File_Index {

	public static function fetchIds($text, $extensions) {
		$sphinx = App_Datastore::getSphinx();

		$ext = implode(',', $extensions);

		if(empty($ext)) { $select = "SELECT id FROM v_sphinx, delta WHERE MATCH('*$text*') LIMIT 1000";
		} else { $select = "SELECT id FROM v_sphinx, delta WHERE extension_int IN ($ext) AND MATCH('*$text*') LIMIT 1000"; }


		return $sphinx->fetchCol($select);
	}

}
