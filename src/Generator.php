<?php

namespace XL2TP;

use XL2TP\Interfaces\ConfigInterface;
use XL2TP\Interfaces\GeneratorInterface;

class Generator implements GeneratorInterface
{
    /**
     * @var \XL2TP\Interfaces\ConfigInterface
     */
    private $config;

    /**
     * Generator constructor.
     *
     * @param \XL2TP\Interfaces\ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Generate L2TP configuration by parameters from memory
     *
     * @return string
     */
    public function generate(): string
    {
        // TODO: Implement generate() method.
    }
}