<?php

function str_split_unicode($str, $l = 0) {
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}


if (!isset($query)) $query = $argv[1];

function force_utf8_safe($str) {
	$res = mb_convert_encoding($str, "UTF-8", "UTF-8" ); // replace invalid characters with ?
	$res = preg_replace('/\p{Cc}+/u', '?', $res); // replace control characters with ?
	return $res;
}

function prepare_output($value) {
	// Make UTF-8 safe results.
	$safe_value = force_utf8_safe($value);
	if ($value != $safe_value) $value = $safe_value;
	return $value;
}

$chars = str_split_unicode($query);

$encoded = $query;

// url
$url_encode = urlencode($query);
if ($url_encode != $query) $encoded = $url_encode;

echo prepare_output($encoded);
