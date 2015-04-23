<?php

function smarty_modifier_isallowed($resource = null, $privilege = null) {
	return Base_Acl::isAllowed($resource, $privilege);
}
