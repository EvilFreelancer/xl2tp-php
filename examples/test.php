<?php
require_once __DIR__ . '/../vendor/autoload.php';

$obj = new \XL2TP\Config();

$obj->global->port          = 123;
$obj->global->authFile      = '/etc/auth/file';
$obj->global->accessControl = 'yes';

$obj->lns->exclusive = 'yes';
$obj->lns->lac       = 'awesome';
$obj->lns->assignIp  = '192.168.1.1';

// Another way for setting section parameters
$obj->lns()->callRws   = 'yes';
$obj->lns()->challenge = 'no';

$obj->lns('test')->exclusive = 'yes';
$obj->lns('test')->lac       = 'awesome';
$obj->lns('test')->assignIp  = '192.168.1.1';

$obj->lac->redial    = 123;
$obj->lac->maxRedial = 1;
$obj->lac->lns       = 'test';

$obj->lac('awesome')->redial    = 123;
$obj->lac('awesome')->maxRedial = 1;
$obj->lac('awesome')->lns       = 'test';

// dd($obj);
echo $obj->generate();