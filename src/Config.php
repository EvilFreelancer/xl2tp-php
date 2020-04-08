<?php

namespace XL2TP;

use XL2TP\Interfaces\ConfigInterface;
use XL2TP\Interfaces\GeneratorInterface;
use XL2TP\Interfaces\SectionInterface;

/**
 * Class Config
 *
 * @property \XL2TP\Interfaces\Sections\GlobalInterface $global
 * @property \XL2TP\Interfaces\Sections\LnsInterface    $lns
 * @property \XL2TP\Interfaces\Sections\LacInterface    $lac
 * @method   \XL2TP\Interfaces\Sections\GlobalInterface global()
 * @method   \XL2TP\Interfaces\Sections\LnsInterface    lns(string $suffix = null)
 * @method   \XL2TP\Interfaces\Sections\LacInterface    lac(string $suffix = null)
 *
 * @package XL2TP
 */
class Config implements ConfigInterface, GeneratorInterface
{
    /**
     * List of preconfigured sections
     *
     * @var array<string, SectionInterface>
     */
    public $sections = [];

    /**
     * Get section of configuration by provided name
     *
     * @param string      $section Name of section
     * @param string|null $suffix  Additional suffix of section name
     *
     * @return \XL2TP\Interfaces\SectionInterface
     * @throws \InvalidArgumentException
     */
    public function section(string $section, string $suffix = null): SectionInterface
    {
        $hash = md5($section . $suffix);
        if (!isset($this->sections[$hash]) || !$this->sections[$hash] instanceof SectionInterface) {
            $this->sections[$hash] = new Section($section, $suffix);
        }

        return $this->sections[$hash];
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
    public function __get(string $name)
    {
        $nameWithSpaces = Helpers::decamelize($name);
        $words          = explode(' ', $nameWithSpaces);
        $section        = $words[0];
        $suffix         = $words[1] ?? null;

        if (!array_key_exists($section, Section::RELATIONS)) {
            throw new \InvalidArgumentException("Required section \"{$section}\" is not allowed");
        }

        return $this->section($section, $suffix);
    }

    /**
     * Get section by name
     *
     * @param string $section
     * @param array  $arguments
     *
     * @return \XL2TP\Interfaces\SectionInterface
     */
    public function __call(string $section, array $arguments)
    {
        if (!array_key_exists($section, Section::RELATIONS)) {
            throw new \InvalidArgumentException("Required section \"{$section}\" is not allowed");
        }

        return $this->section($section, $arguments[0] ?? null);
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
