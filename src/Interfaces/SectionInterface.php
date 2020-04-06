<?php

namespace XL2TP\Interfaces;

interface SectionInterface
{
    /**
     * Check if section has provided parameter
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Set parameter of section
     *
     * @param string      $key
     * @param string|null $value
     *
     * @return \XL2TP\Interfaces\SectionInterface
     */
    public function set(string $key, string $value = null): SectionInterface;

    /**
     * Get value of section
     *
     * @param string $key
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function get(string $key): string;

    /**
     * Remove provided parameter
     *
     * @param string $key
     *
     * @return \XL2TP\Interfaces\SectionInterface
     */
    public function unset(string $key): SectionInterface;
}
