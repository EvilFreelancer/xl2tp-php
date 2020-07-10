[![Latest Stable Version](https://poser.pugx.org/evilfreelancer/xl2tp-php/v/stable)](https://packagist.org/packages/evilfreelancer/xl2tp-php)
[![Build Status](https://scrutinizer-ci.com/g/EvilFreelancer/xl2tp-php/badges/build.png?b=master)](https://travis-ci.org/EvilFreelancer/xl2tp-php)
[![Total Downloads](https://poser.pugx.org/evilfreelancer/xl2tp-php/downloads)](https://packagist.org/packages/evilfreelancer/xl2tp-php)
[![License](https://poser.pugx.org/evilfreelancer/xl2tp-php/license)](https://packagist.org/packages/evilfreelancer/xl2tp-php)
[![Code Coverage](https://scrutinizer-ci.com/g/EvilFreelancer/xl2tp-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/EvilFreelancer/xl2tp-php/?branch=master)
[![Scrutinizer CQ](https://scrutinizer-ci.com/g/evilfreelancer/xl2tp-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/evilfreelancer/xl2tp-php/)

# XL2TP configuration manager on PHP 

XL2TP configuration manager gives you ability to work with a configuration of your services in OOP style.

    composer require evilfreelancer/xl2tp-php

## How to use

Script below

```php
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

echo $obj->generate();
```

Will generate following INI configuration

```ini
[global]
port = 123
auth file = "/etc/auth/file"
access control = "yes"

[lns default]
exclusive = "yes"
lac = "awesome"
assign ip = "192.168.1.1"
call rws = "yes"
challenge = "no"

[lns test]
exclusive = "yes"
lac = "awesome"
assign ip = "192.168.1.1"

[lac default]
redial = 123
max redial = 1
lns = "test"

[lac awesome]
redial = 123
max redial = 1
lns = "test"
```

## Links

* https://linux.die.net/man/5/xl2tpd.conf
* https://linux.die.net/man/8/xl2tpd
* https://github.com/xelerance/xl2tpd/blob/master/examples/xl2tpd.conf
