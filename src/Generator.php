<?php

namespace XL2TP;

use XL2TP\Interfaces\ConfigInterface;
use XL2TP\Interfaces\GeneratorInterface;

class Generator implements GeneratorInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * Generator constructor.
     *
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Render section by parameters in array
     *
     * @param Section $section
     *
     * @return string
     */
    private function render(Section $section): string
    {
        $name = $section->section;
        if ($section->section !== 'global') {
            $name .= $section->suffix ? ' ' . $section->suffix : '';
        }

        $result = "[$name]" . PHP_EOL;
        foreach ($section->parameters as $key => $val) {
            $result .= "$key = " . (is_numeric($val) ? $val : '"' . $val . '"') . PHP_EOL;
        }
        return $result . PHP_EOL;
    }

    /**
     * Generate L2TP configuration by parameters from memory
     *
     * @return string
     */
    public function generate(): string
    {
        $result = '';
        foreach ($this->config->sections as $section) {
            $result .= $this->render($section);
        }
        return $result;
    }
}
