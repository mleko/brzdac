<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type: modifier
 * Name: strpad
 * Purpose: right-pad a string of text to a given length using
 * a given character
 * -------------------------------------------------------------
 */

function smarty_modifier_strpad($input, $pad_length, $pad_string=" ", $type = 'r') {
	$ptypes = array('l' => STR_PAD_LEFT, 'r' => STR_PAD_RIGHT, 'b' => STR_PAD_BOTH);
	$pad_type = isset($ptypes[$type]) ? $ptypes[$type] : STR_PAD_RIGHT;
	return str_pad($input, $pad_length, $pad_string, $pad_type);
}

?>
