<?php

if (!isset($query)) $query = $argv[1];

function force_utf8_safe($str) {
	$res = mb_convert_encoding($str, "UTF-8", "UTF-8" );	// replace invalid characters with ?
	$res = preg_replace('/\p{Cc}+/u', '?', $res);			// replace control characters with ?
	return $res;
}

function prepare_output($value) {
	// Make UTF-8 safe results.
	$safe_value = force_utf8_safe($value);
	if ($value != $safe_value) $value = $safe_value;
	return $value;
}

function html_decode($str) {
	$enc = array("&lt;", "&gt;", '&amp;', '&#039;', '&quot;','&lt;', '&gt;');
	$dec = array("<", ">",'&','\'','"','<','>');
	return str_replace($enc, $dec, htmlspecialchars_decode($str, ENT_NOQUOTES));
}


$decoded = $query;

// HTML
$html_decode = html_entity_decode($query, ENT_QUOTES, 'UTF-8');
if ($html_decode != $query) $decoded = $html_decode;

echo prepare_output($decoded);
