<?php
require_once __DIR__ . '/../vendor/autoload.php';

$obj = new \XL2TP\Config();

$obj->global->port = 123;
$obj->lns->lac = 'test';
$obj->lns('test')->exclusive = 'yes';
$obj->lac()->redial = 123;

// dd($obj);
echo $obj->generate();