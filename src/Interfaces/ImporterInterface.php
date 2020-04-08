<?php

namespace XL2TP\Interfaces;

/**
 * Interface ImporterInterface
 *
 * @package XL2TP\Interfaces
 * @since   1.0.0
 */
interface ImporterInterface
{
    /**
     * Read configuration from file, then it should detect type of content
     *
     * @param string $filename Path to file with INI configuration
     *
     * @return \XL2TP\Interfaces\ImporterInterface
     */
    public function load(string $filename): ImporterInterface;

    /**
     * Load configuration from multidimensional array
     *
     * @param array $configuration
     *
     * @return \XL2TP\Interfaces\ImporterInterface
     */
    public function loadArray(array $configuration): ImporterInterface;

    /**
     * Load configuration from multidimensional array
     *
     * @param array $configuration
     *
     * @return \XL2TP\Interfaces\ImporterInterface
     */
    public function loadJson(array $configuration): ImporterInterface;
}
