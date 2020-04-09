<?php

namespace XL2TP\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use XL2TP\Section;

class SectionTest extends TestCase
{
    public function test__construct(): void
    {
        // Default is 'global'
        $test = new Section();
        $this->assertEquals('global', $test->section);
        $this->assertEquals('default', $test->suffix);

        // lac and lns is allowed
        $test = new Section('lac');
        $this->assertEquals('lac', $test->section);
        $this->assertEquals('default', $test->suffix);

        // Custom lac section
        $test = new Section('lac', 'test');
        $this->assertEquals('lac', $test->section);
        $this->assertEquals('test', $test->suffix);

        // Invalid section
        $this->expectException(InvalidArgumentException::class);
        $test = new Section('dummy');
    }

    public function testSet(): void
    {
        $test = new Section();
        $test->set('listen-addr', '0.0.0.0');
        $this->assertEquals('0.0.0.0', $test->parameters['listen-addr']);

        // Invalid parameter
        $this->expectException(InvalidArgumentException::class);
        $test->set('hello', 'word');
    }

    public function test__set(): void
    {
        $test         = new Section('lac', 'dummy');
        $test->redial = 'why not?';
        $this->assertEquals('why not?', $test->parameters['redial']);
        $this->assertEquals('dummy', $test->suffix);

        // Invalid parameter
        $this->expectException(InvalidArgumentException::class);
        $test->hello = 'word';
    }

    public function testHas(): void
    {
        $test = new Section('lns', 'ballmastrz');
        $this->assertFalse($test->has('exclusive'));
        $test->exclusive = 'yes';
        $this->assertTrue($test->has('exclusive'));
    }

    public function test__isset(): void
    {
        $test = new Section('lns', 'ballmastrz');
        $this->assertFalse(isset($test->exclusive));
        $test->exclusive = 'yes';
        $this->assertTrue(isset($test->exclusive));
    }

    public function testUnset(): void
    {
        $test = new Section('lac', 'test');

        // normal style
        $test->redial = 'test';
        $this->assertTrue(isset($test->redial));
        $test->unset('redial');
        $this->assertFalse(isset($test->redial));

        // magic style
        $test->redial = 'test';
        $this->assertTrue(isset($test->redial));
        $test->redial = null;
        $this->assertFalse(isset($test->redial));
    }

    public function testGet(): void
    {
        $test       = new Section();
        $test->port = 1234;
        $this->assertEquals($test->get('port'), 1234);
    }

    public function test__get(): void
    {
        $test       = new Section();
        $test->port = 1234;
        $this->assertEquals($test->port, 1234);
    }
}
