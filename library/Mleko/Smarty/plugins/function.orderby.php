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
function smarty_function_orderby($params, $template) {
	$retval = "";
	$name = $params['name'];
	$filter = (isset($params['filter']) ? $params['filter'] : array());
	$base_link = $params['link'];

	$filter['orderby'] = $name;
	$filter['orderby_dir'] = 'ASC';
	$link = $base_link . "?" . http_build_query($filter);
	$retval .= '<a href="' . $link . '"><img src="/img/arrow_up.png" /></a>';
	$filter['orderby_dir'] = 'DESC';
	$link = $base_link . "?" . http_build_query($filter);
	$retval .= '<a href="' . $link . '"><img src="/img/arrow_down.png" /></a>';

	return $retval;
}

?>