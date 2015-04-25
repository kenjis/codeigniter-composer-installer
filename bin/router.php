<?php

$file = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'];
//echo $file, PHP_EOL;

if (is_file($file)) {
    return false;
}

//$_SERVER = array_merge($_SERVER, $_ENV);

$_SERVER['SCRIPT_FILENAME'] = $_SERVER['DOCUMENT_ROOT'] . '/' . 'index.php';
//echo $_SERVER['SCRIPT_FILENAME'], PHP_EOL;

require './index.php';
