<?php

$file = 'vendor/codeigniter4/framework/system/Commands/Server/rewrite.php';
$contents = file_get_contents($file);
$contents = str_replace(
    '$fcpath = realpath(__DIR__ . \'/../../../public\') . DIRECTORY_SEPARATOR;',
    '$fcpath = realpath(__DIR__ . \'/../../../../../../public\') . DIRECTORY_SEPARATOR;',
    $contents
);
file_put_contents($file, $contents);
