<?php

namespace Tests\XL2TP;

use BadMethodCallException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use XL2TP\Config;
use XL2TP\Interfaces\Sections\GlobalInterface;

class ConfigTest extends TestCase
{
    protected $object;

    protected function setUp(): void
    {
        $this->object = new Config();
    }

    public function testConstructor(): void
    {
        $object = new Config([
            'global' => [
                'port' => 123,
            ],
        ]);

        self::assertEquals(123, $object->global->port);
    }

    public function testGetter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->dummy->dummy = 123;

        $this->object->global->port = 123;
        self::assertContainsOnlyInstancesOf(GlobalInterface::class, [$this->object->sections[md5('global')]]);
        self::assertEquals(123, $this->object->sections[md5('global')]->parameters['port']);
    }

    public function testIsSetter(): void
    {
        $this->object->global->port = 1234;
        self::assertTrue(isset($this->object->global));
    }

    public function testSetter(): void
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

        self::assertIsString($ini);
        self::assertEquals($ini, $sample);
    }

    public function testCaller(): void
    {
        // Test suite
        $this->object->global()->port       = 123;
        $this->object->global()->listenAddr = '0.0.0.0';
        $this->object->lns()->localIp       = '0.0.0.0';
        $this->object->lac()->redial        = 123;

        // Validation
        self::assertEquals(123, $this->object->sections[md5('global')]->parameters['port']);
        self::assertEquals('0.0.0.0', $this->object->sections[md5('global')]->parameters['listen-addr']);
        self::assertEquals('0.0.0.0', $this->object->sections[md5('lns' . 'default')]->parameters['local ip']);
        self::assertEquals(123, $this->object->sections[md5('lac' . 'default')]->parameters['redial']);

        $this->expectException(InvalidArgumentException::class);
        $this->object->dummy()->dummy = 123;
    }
}
