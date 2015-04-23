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
 * filter, link, paginator
 */
function smarty_function_paginator($params, $template) {
	$retval = "";
	$filter = (isset($params['filter']) ? $params['filter'] : array());
	$base_link = $params['link'];
	$paginator = $params['paginator'];

	if ($paginator->pageCount > 1) {
		$retval .='<div class="paginator"><div class="pages">';
		if (isset($paginator->previous)) {
			$filter['page'] = $paginator->previous;
			$link = $base_link . "?" . http_build_query($filter);
			$retval .= '<a href="' . $link . '">Poprzednia</a>';
		}

		if ($paginator->firstPageInRange - $paginator->first > 2) {
			$filter['page'] = $paginator->first;
			$link = $base_link . "?" . http_build_query($filter);
			$retval .= '<a href="' . $link . '">' . ($paginator->current == $paginator->first ? '<b>' : '') . $paginator->first . ($paginator->current == $paginator->first ? '</b>' : '') . '</a><span>...</span>';
		}

		foreach ($paginator->pagesInRange as $page) {
			$filter['page'] = $page;
			$link = $base_link . "?" . http_build_query($filter);
			$retval .= '<a href="' . $link . '">' . ($paginator->current == $page ? '<b>' : '') . $page . ($paginator->current == $page ? '</b>' : '') . '</a>';
		}

		if ($paginator->last - $paginator->lastPageInRange > 2) {
			$filter['page'] = $paginator->last;
			$link = $base_link . "?" . http_build_query($filter);
			$retval .= '<span>...</span><a href="' . $link . '">' . ($paginator->current == $paginator->last ? '<b>' : '') . $paginator->last . ($paginator->current == $paginator->last ? '</b>' : '') . '</a>';
		}

		if (isset($paginator->next)) {
			$filter['page'] = $paginator->next;
			$link = $base_link . "?" . http_build_query($filter);
			$retval .= '<a href="' . $link . '">Następna</a>';
		}
		$retval.='</div></div>';
	}
	return $retval;
}

?>