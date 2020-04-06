<?php

namespace XL2TP\Interfaces;

interface GeneratorInterface
{
    /**
     * Generate L2TP configuration by parameters from memory
     *
     * @return string
     */
    public function generate(): string;
}
