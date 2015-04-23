<?php

/**
 * Description of List
 *
 * @author mleko
 */
class App_Abstract_List {

    /**
     * @var Zend_Db_Select
     */
    protected $select;

    /**
     * @var array
     */
    protected $extension_list = array();

    public function __construct() {
	$db = Zend_Db_Table::getDefaultAdapter();
	$this->select = $db->select();
    }

    /**
     * @return array
     */
    public function GetData() {
	$query = $this->select->query();
	return $query->fetchAll();
    }

    /**
     * @return array
     */
    /* public function GetArray() {
      return $this->select->query()->fetchAll();
      } */

    /**
     * @param App_Abstract_Filter $filter
     * @return App_Abstract_List 
     */
    public function Filter(App_Abstract_Filter $filter) {
	$filter->Apply($this->select);
	return $this;
    }

    /**
     * @param App_Abstract_ListOrderBy $order
     * @return \App_Abstract_List
     */
    public function Order(App_Abstract_ListOrderBy $order) {
	$order->Apply($this->select);
	return $this;
    }

    /**
     * @param App_Abstract_Extension $extension
     * @return App_Abstract_List 
     */
    public function Apply(App_Abstract_Extension $extension) {
	$ext_name = get_class($extension);
	/* Prevent from aplying same extension couple times */
	if (!in_array($ext_name, $this->extension_list)) {
	    $extension->Apply($this->select);
	    $this->extension_list[] = $ext_name;
	}
	return $this;
    }

    public function Limit($count, $offset = 0) {
	$this->select->limit((int) $count, $offset);
    }

    public function GetPaginator($currentPageNumber = 1, $itemCountPerPage = 40, $pageRange = 8) {
	$adapter = new Zend_Paginator_Adapter_DbSelect($this->select);
	$paginator = new App_Base_Paginator($adapter, static::$item_class);
	$paginator->setItemCountPerPage($itemCountPerPage);
	$paginator->setPageRange($pageRange);
	$paginator->setCurrentPageNumber($currentPageNumber);
	return $paginator;
    }

    public function Log() {
	return $this->select->__toString();
    }

}

?>
