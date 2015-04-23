<?php

abstract class Mleko_Model_List_Filter extends Mleko_Model_List_Plugin {

	abstract public function apply(Zend_Db_Select $select);
}
