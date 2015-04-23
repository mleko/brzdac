<?php

/**
 * Description of Paginator
 *
 * @author mleko
 */
class App_Base_Paginator extends Zend_Paginator {

	/**
	 * @var string
	 */
	protected $item_class = 'Sale_Base_Model';

	public function __construct($adapter, $item_class) {
		parent::__construct($adapter);
		$this->item_class = $item_class;
	}

	function GetData() {
		$data = $this->getCurrentItems();
		$return = array();
		if ($data) {
			foreach ($data as $row) {
				$return[] = new $this->item_class($row);
			}
		}
		return $return;
	}

}

?>
