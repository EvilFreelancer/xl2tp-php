<?php

namespace XL2TP\Tests;

use BadMethodCallException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use XL2TP\Config;
use XL2TP\Interfaces\Sections\GlobalInterface;
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
        $this->assertContainsOnlyInstancesOf(GlobalInterface::class, [$this->object->sections[md5('global')]]);
        $this->assertEquals($this->object->sections[md5('global')]->parameters['port'], 123);
    }

    public function test__isset(): void
    {
        $this->object->global->port = 1234;
        $this->assertTrue(isset($this->object->global));
    }

    public function test__set(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->object->dummy = 123;
    }

    public function testGenerate(): void
    {
        $this->object->global->port          = 123;
        $this->object->global->authFile      = '/etc/auth/file';
        $this->object->global->accessControl = 'yes';
        $this->object->global->listenAddr    = '0.0.0.0';

        $this->object->lns->exclusive = 'yes';
        $this->object->lns->lac       = 'awesome';
        $this->object->lns->assignIp  = '192.168.1.1';

        $sample = "[global]\nport = 123\nauth file = \"/etc/auth/file\"\naccess control = \"yes\"\nlisten-addr = \"0.0.0.0\"\n\n";
        $sample .= "[lns default]\nexclusive = \"yes\"\nlac = \"awesome\"\nassign ip = \"192.168.1.1\"\n\n";
        $ini    = $this->object->generate();

        $this->assertIsString($ini);
        $this->assertEquals($ini, $sample);
    }

    public function test__call(): void
    {
        // Test suite
        $this->object->global()->port       = 123;
        $this->object->global()->listenAddr = '0.0.0.0';
        $this->object->lns()->localIp       = '0.0.0.0';
        $this->object->lac()->redial        = 123;

        // Validation
        $this->assertEquals($this->object->sections[md5('global')]->parameters['port'], 123);
        $this->assertEquals($this->object->sections[md5('global')]->parameters['listen-addr'], '0.0.0.0');
        $this->assertEquals($this->object->sections[md5('lns' . 'default')]->parameters['local ip'], '0.0.0.0');
        $this->assertEquals($this->object->sections[md5('lac' . 'default')]->parameters['redial'], 123);

        $this->expectException(InvalidArgumentException::class);
        $this->object->dummy()->dummy = 123;
    }
}
