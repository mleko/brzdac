<?php

/**
 *
 * @author mleko
 */
class Crm_Acl_Rules implements Abstract_Acl_Rules {

	static public function apply(Zend_Acl $acl) {
		$acl->addResource(($crm = new Zend_Acl_Resource('moduleCrm')));
		$acl->allow('user', $crm, NULL, new Crm_Acl_Assert_Access());
	}

}
