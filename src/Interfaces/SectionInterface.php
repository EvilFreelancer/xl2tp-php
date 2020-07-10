<?php

declare(strict_types=1);

namespace XL2TP\Interfaces;

/**
 * Interface SectionInterface
 *
 * @package XL2TP\Interfaces
 * @since   1.0.0
 */
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
     * @param string $key
     * @param string $value
     *
     * @return \XL2TP\Interfaces\SectionInterface
     */
    public function set(string $key, string $value): SectionInterface;

    /**
     * Get value of section
     *
     * @param string $key
     *
     * @return string|int|null
     */
    public function get(string $key);

    /**
     * Remove provided parameter
     *
     * @param string $key
     *
     * @return void
     */
    public function unset(string $key): void;
}
