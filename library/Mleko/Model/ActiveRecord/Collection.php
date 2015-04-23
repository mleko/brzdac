<?php

/**
 *
 * @author mleko
 */
class Mleko_Model_ActiveRecord_Collection extends Mleko_Model_List_Template {

	/**
	 *
	 * @var Abstract_Model_ActiveRecord_Paginator
	 */
	protected $paginator = null;
	protected $className;

	public function __construct($select, $className) {
		$this->className = $className;
		parent::__construct($select, false);
	}

	/**
	 *
	 * @return Abstract_Model_ActiveRecord_Paginator
	 */
	public function getPaginator() {
		if(is_null($this->paginator)) {
			$adapter = new Zend_Paginator_Adapter_DbSelect($this->select);
			$this->paginator = new Abstract_Model_ActiveRecord_Paginator($adapter, $this->className);
		}

		return $this->paginator;
	}

	public function getObjects($limit = false) {
		if($limit) { $this->select->limit($limit); }
		$query = $this->select->query();

		$className = $this->className;
		$objects = array();
		foreach($query as $row) {
			$id = $row['id'];
			$object = $className::get($id);
			$objects[] = $object;
		}
		return $objects;
	}

}
