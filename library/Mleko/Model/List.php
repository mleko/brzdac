<?php

/**
 *
 * @author mleko
 */
abstract class Mleko_Model_List extends Mleko_Model_List_Template {

	/** @var Zend_Paginator */
	private $paginator;

	/**
	 * @return Abstract_Model_Paginator
	 */
	public function getPaginator() {
		if(is_null($this->paginator)) {
			$adapter = new Zend_Paginator_Adapter_DbSelect($this->select);
			$this->paginator = new Abstract_Model_Paginator($adapter);
		}

		return $this->paginator;
	}

	/**
	 * @return Zend_Db_Statement
	 */
	final public function getResult() {
		return $this->select->query();
	}

	/**
	 * @return array
	 */
	final public function getArray($limit = null) {
		if(!is_null($limit)) $this->select->limit($limit);
		return $this->select->query()->fetchAll();
	}

	/**
	 * @return array
	 */
	final public function getAssoc($limit = null) {
		if(!is_null($limit)) $this->select->limit($limit);
		$result = $this->getResult();

		$data = array();
		while($row = $result->fetch()) {
			$cnt = count($row); reset($row);
			switch($cnt) {
				default: $data[current($row)] = $row; break;
				case 1: $data[] = current($row); break;
				case 2: $data[current($row)] = next($row); break;
			}
		}

		return $data;
	}

}

?>
