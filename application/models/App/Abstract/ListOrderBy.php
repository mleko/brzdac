<?php

/**
 * Description of ListOrderBy
 *
 * @author mleko
 */
abstract class App_Abstract_ListOrderBy implements App_Abstract_Extension {

	/**
	 * @var string
	 */
	private $orderby;

	/**
	 * @var string
	 */
	private $order_dir;

	/**
	 * @var array
	 */
	protected static $binds = array();

	public function __construct($orderby, $orderby_dir) {
		$this->orderby = $orderby;
		$this->order_dir = $orderby_dir;
	}

	public function Apply(Zend_Db_Select &$select) {
		if(isset(static::$binds[$this->orderby]) && in_array($this->order_dir, array('ASC', 'DESC'))) {
			$select->order(static::$binds[$this->orderby] . ' ' . ($this->order_dir == 'ASC' ? 'ASC' : 'DESC'));
		} else {
			throw new Exception('Undefined orderby method: ' . $this->orderby);
		}
	}

}

?>
