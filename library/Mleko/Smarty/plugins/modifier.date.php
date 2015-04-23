<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type: modifier
 * Name: date
 * Purpose: format date using php date function and format
 * -------------------------------------------------------------
 */

function smarty_modifier_date($input, $format) {
	return date($format, $input);
}

?>
