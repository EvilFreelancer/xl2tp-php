<?php

namespace XL2TP\Interfaces;

/**
 * Interface ConfigInterface
 *
 * @package XL2TP\Interfaces
 * @since   1.0.0
 */
interface ConfigInterface
{
    /**
     * Get section of configuration by provided name
     *
     * @param string|null $name Name of section
     *
     * @return \XL2TP\Interfaces\SectionInterface
     * @throws \InvalidArgumentException
     */
    public function section(string $name): SectionInterface;
}
