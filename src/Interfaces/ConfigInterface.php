<?php

declare(strict_types=1);

namespace XL2TP\Interfaces;

/**
 * Interface ConfigurationInterface
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
     */
    public function section(string $name): SectionInterface;
}
