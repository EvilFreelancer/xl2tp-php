<?php

namespace OpenVPN;

use RuntimeException;

class Helpers
{
    /**
     * Convert string like "makeMeHappy" to "make me happy"
     *
     * @param string $input
     *
     * @return string
     */
    public static function decamelize(string $input): string
    {
        // It's for global section
        if ($input === 'listenAddr') {
            return 'listen-addr';
        }

        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $result = $matches[0];
        foreach ($result as &$match) {
            $match = $match === strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode(' ', $result);
    }

}
