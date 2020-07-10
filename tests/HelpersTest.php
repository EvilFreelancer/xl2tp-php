<?php

namespace Tests\XL2TP;

use PHPUnit\Framework\TestCase;
use XL2TP\Helpers;

class HelpersTest extends TestCase
{
    public function decamelizeDataProvider(): array
    {
        return [
            ['in' => 'testString', 'out' => 'test string'],
            ['in' => 'aweSomeTest', 'out' => 'awe some test'],
            ['in' => 'listenAddr', 'out' => 'listen-addr'],
        ];
    }

    /**
     * @dataProvider decamelizeDataProvider
     *
     * @param string $in
     * @param string $out
     */
    public function testDecamelize(string $in, string $out): void
    {
        $test = Helpers::decamelize($in);
        self::assertEquals($out, $test);
    }
}
