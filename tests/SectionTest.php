<?php

namespace Tests\XL2TP;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use XL2TP\Section;

class SectionTest extends TestCase
{
    public function testConstruct(): void
    {
        // Default is 'global'
        $test = new Section();
        self::assertEquals('global', $test->section);
        self::assertEquals('default', $test->suffix);

        // lac and lns is allowed
        $test = new Section('lac');
        self::assertEquals('lac', $test->section);
        self::assertEquals('default', $test->suffix);

        // Custom lac section
        $test = new Section('lac', 'test');
        self::assertEquals('lac', $test->section);
        self::assertEquals('test', $test->suffix);

        // Invalid section
        $this->expectException(InvalidArgumentException::class);
        $test = new Section('dummy');
    }

    public function testSet(): void
    {
        $test = new Section();
        $test->set('listen-addr', '0.0.0.0');
        self::assertEquals('0.0.0.0', $test->parameters['listen-addr']);

        // Invalid parameter
        $this->expectException(InvalidArgumentException::class);
        $test->set('hello', 'word');
    }

    public function testSetter(): void
    {
        $test         = new Section('lac', 'dummy');
        $test->redial = 'why not?';
        self::assertEquals('why not?', $test->parameters['redial']);
        self::assertEquals('dummy', $test->suffix);

        // Invalid parameter
        $this->expectException(InvalidArgumentException::class);
        $test->hello = 'word';
    }

    public function testHas(): void
    {
        $test = new Section('lns', 'ballmastrz');
        self::assertFalse($test->has('exclusive'));
        $test->exclusive = 'yes';
        self::assertTrue($test->has('exclusive'));
    }

    public function testIsSetter(): void
    {
        $test = new Section('lns', 'ballmastrz');
        self::assertFalse(isset($test->exclusive));
        $test->exclusive = 'yes';
        self::assertTrue(isset($test->exclusive));
    }

    public function testUnset(): void
    {
        $test = new Section('lac', 'test');

        // normal style
        $test->redial = 'test';
        self::assertTrue(isset($test->redial));
        $test->unset('redial');
        self::assertFalse(isset($test->redial));

        // magic style
        $test->redial = 'test';
        self::assertTrue(isset($test->redial));
        $test->redial = null;
        self::assertFalse(isset($test->redial));
    }

    public function testGet(): void
    {
        $test       = new Section();
        $test->port = 1234;
        self::assertEquals(1234, $test->get('port'));
    }

    public function testGetter(): void
    {
        $test       = new Section();
        $test->port = 1234;
        self::assertEquals(1234, $test->port);
    }
}
