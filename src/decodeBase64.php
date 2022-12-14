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


$decoded = $query;

$base64_decode = base64_decode($query, true);
if ($base64_decode && $base64_decode != $query) $decoded = $base64_decode;

echo prepare_output($decoded);
