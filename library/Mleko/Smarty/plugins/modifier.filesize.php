<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type: modifier
 * Name: date
 * Purpose: format date using php date function and format
 * -------------------------------------------------------------
 */

function smarty_modifier_filesize($input) {
	$units = array('B', 'KiB', 'MiB', 'GiB', 'TiB');

	$l = log($input?:1, 2);
	$unitr = floor($l / 10);
	if ($unitr > max(array_keys($units)))
		$unitr = max(array_keys($units));
	$unit = $units[$unitr];


	return round($input / pow(2, 10 * $unitr), 2) . ' ' . $unit;
}

?>
