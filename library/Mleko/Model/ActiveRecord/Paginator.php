<?php

/**
 *
 * @author mleko
 */
class Mleko_Model_ActiveRecord_Paginator extends Abstract_Model_Paginator {

	protected $className;

	public function __construct($adapter, $className) {
		$this->className = $className;
		parent::__construct($adapter);
	}

	public function getCurrentItems() {
		$items = parent::getCurrentItems();
		$className = $this->className;
		$objects = array();
		foreach($items as $value) {
			$id = $value['id'];
			$object = $className::get($id);
			$objects[] = $object;
		}
		return $objects;
	}

}

?>
