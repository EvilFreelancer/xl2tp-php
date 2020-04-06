<?php
require_once __DIR__ . '/../vendor/autoload.php';

$obj = new \XL2TP\Config();

$obj->global->port = 123;
$obj->lnsDefault->port = 123;
$obj->lns('test')->port = 123;
$obj->lac()->port = 123;

dd($obj);
