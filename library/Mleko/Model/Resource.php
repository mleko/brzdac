<?php

abstract class Mleko_Model_Resource {

	protected $data = null;
	protected $updates = array();
	protected static $fields = array();

	abstract public function load();

	/**
	 * @return TRUE|FALSE|NULL TRUE - successfull, FALSE - failure, NULL - noChanges
	 */
	abstract public function save($noCreate = false);

	public function __isset($var) {
		$var = strtolower(preg_replace('/([A-Z])/', '_$1', $var));

		if(is_null($this->data)) $this->load();
		if($this->data === false) return false;

		if(!is_array($this->data)) throw new Exception('Data is not an array - check ' . get_class($this) . ' loader.');
		return array_key_exists($var, $this->data);
	}

	public function __get($var) {
		$var = strtolower(preg_replace('/([A-Z])/', '_$1', $var));

		if(is_array($this->updates) && array_key_exists($var, $this->updates)) return $this->updates[$var];
		if(is_null($this->data)) $this->load();
		if($this->data === false) return null;

		if(!is_array($this->data)) throw new Exception('Data is not an array - check ' . get_class($this) . ' loader.');
		if(!array_key_exists($var, $this->data)) throw new Exception($var . ' is not available on ' . get_class($this));
		return $this->data[$var];
	}

	public function __set($var, $value) {
		return $this->setUpdateValue($var, $value, true);
	}

	public function update($values) {
		foreach($values as $var => $value) {
			$this->setUpdateValue($var, $value, false);
		}

		return true;
	}

	protected function setUpdateValue($var, $value, $throwInvalid = true) {
		$var = strtolower(preg_replace('/([A-Z])/', '_$1', $var));

		if(!is_array(static::$fields)) throw new Exception('Fields is not array - check ' . get_class($this) . ' definition.');
		if(array_search($var, static::$fields) === false) {
			if($throwInvalid) throw new Exception('You cant set ' . $var . ' on ' . get_class($this));
			else return false;
		}

		if(!$value && !is_numeric($value)) $value = null;
		$this->updates[$var] = $value;
		return true;
	}

	public function checkUpdateValue($var, $allowNonexistent = false) {
		if(array_key_exists($var, $this->updates)) return is_null($this->updates[$var]) ? false : true;
		else return $allowNonexistent ? true : false;
	}

}
