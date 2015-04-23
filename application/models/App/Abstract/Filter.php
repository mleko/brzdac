<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author mleko
 */
interface App_Abstract_Filter{
	public function Apply(Zend_Db_Select &$select);
}

?>
