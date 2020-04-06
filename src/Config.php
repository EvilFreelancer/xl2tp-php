<?php

namespace XL2TP;

use XL2TP\Helpers;
use XL2TP\Interfaces\ConfigInterface;
use XL2TP\Interfaces\GeneratorInterface;
use XL2TP\Interfaces\SectionInterface;

/**
 * Class Config
 *
 * @property \XL2TP\Interfaces\Sections\GlobalInterface $global
 * @property \XL2TP\Interfaces\Sections\LnsInterface    $lns
 * @property \XL2TP\Interfaces\Sections\LacInterface    $lac
 * @method global(): \XL2TP\Interfaces\Sections\GlobalInterface
 * @method lns(string $name = null): \XL2TP\Interfaces\Sections\LnsInterface
 * @method lac(string $name = null): \XL2TP\Interfaces\Sections\LacInterface
 *
 * @package XL2TP
 */
class Config implements ConfigInterface, GeneratorInterface
{
    /**
     * List of preconfigured sections
     *
     * @var array<int, SectionInterface>
     */
    private $sections = [];

    /**
     * Allowed default sections
     *
     * @var array
     */
    private $allowed = [
        'global',
        'lns',
        'lac'
    ];

    /**
     * Get section of configuration by provided name
     *
     * @param string $name Name of section
     *
     * @return \XL2TP\Interfaces\SectionInterface
     * @throws \InvalidArgumentException
     */
    public function section(string $name): SectionInterface
    {
        if (!isset($this->sections[$name]) || !$this->sections[$name] instanceof SectionInterface) {
            $this->sections[$name] = new Section($name);
        }

        return $this->sections[$name];
    }

    /**
     * If required section is set
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->sections[$name]);
    }

    /**
     * Bad method call, not allowed here
     *
     * @param string $name
     * @param string $value
     */
    public function __set(string $name, string $value)
    {
        throw new \BadMethodCallException('Provided method is not allowed');
    }

    /**
     * Get section by name
     *
     * @param string $name
     *
     * @return \XL2TP\Interfaces\SectionInterface
     * @throws \InvalidArgumentException
     */
    public function __get(string $name = null)
    {
        $nameWithSpaces = Helpers::decamelize($name);
        $words          = explode(' ', $nameWithSpaces);
        $name           = $words[0];

        if (!in_array($name, $this->allowed, true)) {
            throw new \InvalidArgumentException('Required section is not allowed here');
        }

        // Add default suffix of section if not global
        if (mb_strtolower($name) !== 'global') {
            if (empty($words[1])) {
                $name .= ' default';
            } else {
                $name .= ' ' . $words[1];
            }
        }

        return $this->section($name);
    }

    /**
     * Get section by name
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return \XL2TP\Interfaces\SectionInterface
     */
    public function __call(string $name, array $arguments)
    {
        if (!in_array($name, $this->allowed, true)) {
            throw new \InvalidArgumentException('Required section is not allowed here');
        }

        // Add default suffix of section if not global
        if (mb_strtolower($name) !== 'global') {
            if (empty($arguments[0])) {
                $name .= ' default';
            } else {
                $name .= ' ' . $arguments[0];
            }
        }

        return $this->section($name);
    }

    /**
     * Generate L2TP configuration by parameters from memory
     *
     * @return string
     */
    public function generate(): string
    {
        $generator = new Generator($this);
        return $generator->generate();
    }
}
