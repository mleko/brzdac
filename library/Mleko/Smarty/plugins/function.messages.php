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
function smarty_function_messages($params, $template) {
	$retval = "";
	$messages = $params['messages'];

	$type = array(
		'error' => array('class' => 'ui-state-error ui-corner-all', 'icon' => 'ui-icon ui-icon-alert'),
		'info' => array('class' => 'ui-state-highlight ui-corner-all', 'icon' => 'ui-icon ui-icon-info'),
		'success' => array('class' => 'ui-state-ok ui-corner-all', 'icon' => 'ui-icon ui-icon-check')
	);

	foreach ($type as $key => $value) {
		if ((isset($messages[$key]) ? $messages[$key] : NULL)) {
			$retval .= "<div class='ui-widget'><div class='{$value['class']}' style='margin-top: 5px; padding: 0 .7em;'>";
			foreach ($messages[$key] as $message) {
				$retval .= "<p><span class='{$value['icon']}' style='float: left; margin-right: .3em;' ></span>{$message}</p>";
			}
			$retval .= "</div></div>";
		}
	}
	
	return $retval;
}

?>
