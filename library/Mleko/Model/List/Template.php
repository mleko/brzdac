<?php

abstract class Mleko_Model_List_Template {

	/** @var Zend_Db_Select */
	protected $select;
	protected $extensions;
	protected $fetchData;

	public function __construct(Zend_Db_Select $select, $fetchData = true) {
		$this->select = $select;
		$this->fetchData = $fetchData;
		$this->paginator = null;

		$this->extensions = array();
	}

	public function addExtension(Mleko_Model_List_Extension $extension) {
		$name = get_class($extension);

		if(isset($this->extensions[$name])) throw new Exception("Extension {$name} is already set");

		$extension->extend($this);
		$extension->join($this->select, $this->fetchData);

		$this->extensions[$name] = $extension;
		return true;
	}

	public function hasExtension($name) {
		return isset($this->extensions[$name]);
	}

	public function getExtension($name) {
		if(!$this->hasExtension($name)) throw new Exception("Extension {$name} is not present");
		return $this->extensions[$name];
	}

	public function addFilter(Mleko_Model_List_Filter $filter) {
		$filter->extend($this);
		$filter->apply($this->select);
		return true;
	}

}
