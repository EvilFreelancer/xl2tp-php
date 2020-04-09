<?php

namespace XL2TP\Tests;

use Exception;
use XL2TP\Config;
use XL2TP\Generator;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    protected $object;

    protected function setUp(): void
    {
        $this->object = new Generator(new Config());
    }

    public function test__construct(): void
    {
        try {
            $this->assertIsObject($this->object);
            $this->assertInstanceOf(Generator::class, $this->object);
        } catch (Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testGenerate(): void
    {
        $obj = new Config();
        $obj->global->port          = 123;
        $obj->global->authFile      = '/etc/auth/file';
        $obj->global->accessControl = 'yes';
        $obj->lns->exclusive = 'yes';
        $obj->lns->lac       = 'awesome';
        $obj->lns->assignIp  = '192.168.1.1';
        $this->assertIsString($obj->generate());
    }
}
