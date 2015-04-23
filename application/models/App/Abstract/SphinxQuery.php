<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SphinxQuery
 *
 * @author mleko
 */
abstract class App_Abstract_SphinxQuery {
    protected $sphinx = NULL;
    public function __construct() {
	$this->sphinx = App_Datastore::getSphinx();
    }
}

?>
