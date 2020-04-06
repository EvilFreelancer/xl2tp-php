<?php
require_once __DIR__ . '/../vendor/autoload.php';

$obj = new \XL2TP\Config();

$obj->global->port = 123;

dd($obj);
