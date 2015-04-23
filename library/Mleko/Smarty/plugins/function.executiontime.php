<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 *
 * @param type $params
 * @param type $template
 * @return string
 */
function smarty_function_executiontime($params, $template) {
	if (defined('SCRIPT_GENERATION_START'))
		return microtime(true) - SCRIPT_GENERATION_START;
	return NULL;
}

?>
