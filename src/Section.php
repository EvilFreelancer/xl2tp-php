<?php

namespace XL2TP;

use XL2TP\Interfaces\SectionInterface;

class Section implements SectionInterface
{
    protected $name = 'global';

    /**
     * Section constructor.
     *
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        if (!empty($name)) {
            $this->name = $name;
        }
    }

    public function has(string $key): bool
    {
        // TODO: Implement has() method.
    }

    public function get(string $key): string
    {
        // TODO: Implement get() method.
    }

    public function set(string $key, string $value = null): SectionInterface
    {
        // TODO: Implement set() method.
    }

    public function unset(string $key): SectionInterface
    {
        // TODO: Implement unset() method.
    }
}
