<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchVisit
 *
 * @author mleko
 */
class App_Log_SearchVisit {

	public static function log($host, $search_phrase = NULL, $search_file_type = NULL, $result_count = 0) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$bind = array(
			'host' => ip2long($host)
		);
		if(NULL !== $search_phrase && NULL !== $search_file_type) {
			$bind['search_phrase'] = $search_phrase;
			$bind['search_file_type'] = $search_file_type;
			$bind['search_result_count'] = $result_count;
		}
		$db->insert('search_visit_log', $bind);
	}

}
