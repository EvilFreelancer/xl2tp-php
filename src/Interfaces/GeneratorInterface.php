<?php

namespace XL2TP\Interfaces;

/**
 * Interface GeneratorInterface
 *
 * @package XL2TP\Interfaces
 * @since   1.0.0
 */
interface GeneratorInterface
{
    /**
     * Generate L2TP configuration by parameters from memory
     *
     * @return string
     */
    public function generate(): string;
}
