<?php

abstract class Mleko_Model_List_Extension extends Mleko_Model_List_Plugin {

	abstract public function join(Zend_Db_Select $select, $fetchData = true);
}
