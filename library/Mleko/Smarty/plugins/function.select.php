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
 * 
 * param['name'] - defines select name and source arrays, data are fetched from template variables
 */
function smarty_function_select($params, $template) {
	$retval = "";
	$id = $params['name'];
	$array = (array)$params['array'];
	$selected = $params['selected'];
	
	$etc = isset($params['etc']) ? $params['etc'] : '';

	$width = isset($params['width']) ? $params['width'] : NULL;
	$autosubmit = (isset($params['autosubmit']) ? $params['autosubmit'] : 0);

	$retval .= '<select id="' . $id . '" name="' . $id . '" ' .
			($width ? 'style="width: ' . $width . 'px;"' : '') .
			($autosubmit ? ' onChange="submit();" ' : '') . $etc . '>';

	foreach ($array as $oid => $option) {
		$retval .= '<option ' . ($oid == $selected ? "selected='selected'" : '') . ' value="' . $oid . '">' . $option . '</option>';
	}
	$retval .= '</select>';
	return $retval;
}

?>