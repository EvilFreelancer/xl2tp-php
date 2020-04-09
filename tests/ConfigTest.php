<?php

namespace XL2TP\Tests;

use BadMethodCallException;
use InvalidArgumentException;
use XL2TP\Config;
use PHPUnit\Framework\TestCase;
use XL2TP\Section;

class ConfigTest extends TestCase
{
    protected $object;

    protected function setUp(): void
    {
        $this->object = new Config();
    }

    public function test__get(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->dummy->dummy = 123;
        $this->object->global->port = 123;
        $this->assertContainsOnlyInstancesOf(Section::class, [$this->object->global()]);
        $this->object->global->port = 123;
        $this->assertEquals($this->object->section('global')->parameters['port'], 123);
    }

    public function test__set(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->object->dummy = 123;
    }

    // Раскоментить после
//    public function testGenerate(): void
//    {
//        $this->object->global->port = 123;
//        $this->object->lns->localIp = '0.0.0.0';
//        $this->object->lns('test')->exclusive = 'yes';
//        $this->assertIsString($this->object->generate());
//    }

    public function test__call(): void
    {
        $this->object->global->port = 123;
        $this->object->global->listenAddr = '0.0.0.0';
        $this->object->lns->localIp = '0.0.0.0';
        $this->object->lac->redial = 123;
        $this->assertEquals($this->object->lns()->parameters['local ip'], '0.0.0.0');
        $this->assertEquals($this->object->lac()->parameters['redial'], 123);
        $this->assertEquals($this->object->global()->parameters['port'], 123);
        $this->assertEquals($this->object->global()->parameters['listen-addr'], '0.0.0.0');
        $this->expectException(InvalidArgumentException::class);
        $this->object->dummy()->dummy = 123;
    }
}
