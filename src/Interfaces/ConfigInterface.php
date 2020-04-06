<?php

namespace XL2TP\Interfaces;

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
