<?php


$base_uri = rtrim(fixslashes(dirname($_SERVER['SCRIPT_NAME'])), '/');
if (empty($base_uri)) {
    $base_uri = '/';
}

function redirect($uri) {
    header('Location: ' . preg_replace('/\/+/', '/', $base_uri . $uri));
}

function fixSlashes($str)
{
    return $str ? strtr($str, '\\', '/') : $str;
}
