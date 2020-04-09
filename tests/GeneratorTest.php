<?php

namespace XL2TP\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use XL2TP\Config;
use XL2TP\Generator;

class GeneratorTest extends TestCase
{
    /**
     * @var \XL2TP\Generator
     */
    protected $object;

    protected function setUp(): void
    {
        $obj = new Config();

        $obj->global->port          = 123;
        $obj->global->authFile      = '/etc/auth/file';
        $obj->global->accessControl = 'yes';
        $obj->global->listenAddr    = '0.0.0.0';

        $obj->lns->exclusive = 'yes';
        $obj->lns->lac       = 'awesome';
        $obj->lns->assignIp  = '192.168.1.1';

        $this->object = new Generator($obj);
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
        $sample = "[global]\nport = 123\nauth file = \"/etc/auth/file\"\naccess control = \"yes\"\nlisten-addr = \"0.0.0.0\"\n\n";
        $sample .= "[lns default]\nexclusive = \"yes\"\nlac = \"awesome\"\nassign ip = \"192.168.1.1\"\n\n";
        $ini    = $this->object->generate();

        $this->assertIsString($ini);
        $this->assertEquals($ini, $sample);
    }

    public function testGenerateEx(): void
    {
        $this->expectException(RuntimeException::class);
        $this->object->config = 'test';
        $this->object->generate();
    }
}
