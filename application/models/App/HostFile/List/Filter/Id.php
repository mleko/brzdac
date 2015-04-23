<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Id
 *
 * @author mleko
 */
class App_HostFile_List_Filter_Id implements App_Abstract_Filter{
    private $id_ = FALSE;
    
    public function __construct($id) {
	if(is_array($id)){
	    $this->id_ = $id;
	    array_walk($this->id_, 'intval');
	}else{
	    $this->id_ = intval($id);
	}
    }

    public function Apply(\Zend_Db_Select &$select) {
	if(!$this->id_)
	    $select->where ('0=1');
	else if(is_array($this->id_))
	    $select->where('hf.id IN (?)', $this->id_);
	else
	    $select->where('hf.id = ?', $this->id_);
    }
}

?>
