<?php

/**
 *
 * @author mleko
 */
class App_Doodle {

	private $doodleId;

	public function __construct($doodleId) {
		$this->doodleId = $doodleId;
	}

	public function save($data) {
		$db = App_Datastore::getMySQL();

		$bind = array();
		if(isset($data['start'])) $bind['start'] = $data['start'];
		if(isset($data['end'])) $bind['end'] = $data['end'];
		if(isset($data['enabled'])) $bind['enabled'] = $data['enabled'];
		if(isset($data['file_id'])) $bind['file_id'] = $data['file_id'];
		if(isset($data['description'])) $bind['description'] = $data['description'];


		if($this->doodleId) {
			return FALSE !== $db->update('doodle', $bind, array('id = ?' => $this->doodleId));
		} else {
			if(FALSE === $db->insert('doodle', $bind)) return FALSE;
			$this->doodleId = $db->lastInsertId();
			return TRUE;
		}
		return FALSE;
	}

	public function data() {
		$db = App_Datastore::getMySQL();
		return $db->fetchRow($db->select()->from('doodle')
								->join('doodle_file', 'doodle.file_id = doodle_file.id', array('name'))
								->where('doodle.id = ?', $this->doodleId));
	}

	public static function getDoodle($id = NULL) {
		$db = App_Datastore::getMySQL();

		$select = $db->select()->from('doodle')
				->join('doodle_file', 'doodle.file_id = doodle_file.id', array('name'));
		if($id) {
			$select->where('doodle.id = ?', $id);
		} else {
			$select->where('doodle.enabled = 1')
					->where('doodle.start <= DATE(NOW())')
					->where('doodle.end >= DATE(NOW())');
		}
		$select->limit(1)->order('RAND()');

		return $db->fetchRow($select);
	}

}

?>
