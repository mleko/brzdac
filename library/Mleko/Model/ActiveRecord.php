<?php

/**
 *
 * @author mleko
 */
abstract class Mleko_Model_ActiveRecord extends Mleko_Model_Resource {

	/**
	 * @var Zend_Db_Adapter_Abstract
	 */
	static private $model = array();
//
	protected $activeRecordPrimaryKeyValue = null;

	static protected function provideModel($db = null, $table = null, $primaryKeyColumn = null) {
		if(null === $db || null === $table || null === $primaryKeyColumn) throw new Exception("Model data unspecified");
		$modelArray = array(
			'db' => $db,
			'table' => $table,
			'pkColumn' => $primaryKeyColumn
		);
		return $modelArray;
	}

	static private function getModel() {
		$class = get_called_class();
		if(!isset(self::$model[$class])) {
			$classModel = $class::provideModel();
			self::$model[$class] = $classModel;
		}
		return self::$model[$class];
	}

	protected function __construct($pkVal = null) {
		$this->activeRecordPrimaryKeyValue = $pkVal;
	}

	/**
	 *
	 * @param type $pk
	 * @return Abstract_Model_ActiveRecord
	 */
	static public function get($pk = null) {
		if(null !== $pk) {
			$record = Mleko_Model_ActiveRecord_Registry::get(get_called_class(), $pk);
			if(null !== $record) {
				return $record;
			}
		}
		$object = new static($pk);
		Mleko_Model_ActiveRecord_Registry::set(get_called_class(), $pk, $object);
		return $object;
	}

	/**
	 *
	 * @param boolean $fetchObjects
	 * @return \Mleko_Model_ActiveRecord_Collection
	 */
	static public function objectCollection() {
		$model = static::getModel();

		$select = $model['db']->select()->from(array('root' => $model['table']), array('id' => $model['pkColumn']));
		$list = new Mleko_Model_ActiveRecord_Collection($select, get_called_class());
		return $list;
	}

	public function load() {
		$model = static::getModel();
		if(null !== $this->activeRecordPrimaryKeyValue) {
			$select = $model['db']->select()->from($model['table'], '*')->where($model['pkColumn'] . " = ?", $this->activeRecordPrimaryKeyValue);
			$this->data = $select->query()->fetch();
			return (false !== $this->data) ? true : false;
		}
		return ($this->data = false);
	}

	public function save($noCreate = false) {
		$model = static::getModel();
		if(empty($this->updates) && $this->activeRecordPrimaryKeyValue) null;

		if(!($this->activeRecordPrimaryKeyValue)) {
			if($noCreate) return false;
			if(false === $model['db']->insert($model['table'], $this->updates)) return false;
			$this->activeRecordPrimaryKeyValue = $model['db']->lastInsertId($model['table']);
			Mleko_Model_ActiveRecord_Registry::set(get_class(), $this->activeRecordPrimaryKeyValue, $this);
		} else {
			if(false === $model['db']->update($model['table'], $this->updates,
							array($model['pkColumn'] . " = ?" => $this->activeRecordPrimaryKeyValue))) return false;
		}

		$this->data = $this->updates = null;
		return true;
	}

	public function delete() {
		$model = static::getModel();
		return $model['db']->delete($model['table'], array($model['pkColumn'] . ' = ?' => $this->activeRecordPrimaryKeyValue));
	}

}

?>
