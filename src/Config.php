<?php

declare(strict_types=1);

namespace XL2TP;

use BadMethodCallException;
use InvalidArgumentException;
use XL2TP\Interfaces\ConfigInterface;
use XL2TP\Interfaces\GeneratorInterface;
use XL2TP\Interfaces\SectionInterface;

/**
 * Class Configuration
 *
 * @property \XL2TP\Interfaces\Sections\GlobalInterface $global
 * @property \XL2TP\Interfaces\Sections\LacInterface    $lac
 * @property \XL2TP\Interfaces\Sections\LnsInterface    $lns
 * @method   \XL2TP\Interfaces\Sections\GlobalInterface global()
 * @method   \XL2TP\Interfaces\Sections\LacInterface    lns(string $suffix = null)
 * @method   \XL2TP\Interfaces\Sections\LnsInterface    lac(string $suffix = null)
 *
 */
class Config implements ConfigInterface, GeneratorInterface
{
    /**
     * List of preconfigurationured sections
     *
     * @var array<string, \XL2TP\Interfaces\SectionInterface>
     */
    public $sections = [];

    /**
     * Configuration constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
        foreach ($configuration as $section => $values) {
            foreach ($values as $key => $value) {
                $this->$section->set($key, $value);
            }
        }
    }

    /**
     * Get section of configuration by provided name
     *
     * @param string      $section Name of section
     * @param string|null $suffix  Additional suffix of section name
     *
     * @return \XL2TP\Interfaces\SectionInterface
     */
    public function section(string $section, string $suffix = null): SectionInterface
    {
        if (empty($suffix) && 'global' !== mb_strtolower(trim($section))) {
            $suffix = 'default';
        }

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
        $nameWithSpaces = Helpers::decamelize($name);
        $words          = explode(' ', $nameWithSpaces);
        $section        = $words[0];
        $suffix         = $words[1] ?? null;

        $hash = md5($section . $suffix);

        return isset($this->sections[$hash]);
    }

    /**
     * Bad method call, not allowed here
     *
     * @param string $name
     * @param string $value
     *
     * @throws \BadMethodCallException Because method is readonly
     */
    public function __set(string $name, string $value)
    {
        throw new BadMethodCallException('Provided method is not allowed');
    }

    /**
     * Get section by name
     *
     * @param string $name
     *
     * @return \XL2TP\Interfaces\SectionInterface
     * @throws \InvalidArgumentException If section is not allowed
     */
    public function __get(string $name): SectionInterface
    {
        $nameWithSpaces = Helpers::decamelize($name);
        $words          = explode(' ', $nameWithSpaces);
        $section        = $words[0];
        $suffix         = $words[1] ?? null;

        if (!array_key_exists($section, Section::RELATIONS)) {
            throw new InvalidArgumentException('Required section "' . $section . '" is not allowed');
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
     * @throws \InvalidArgumentException If section is not allowed
     */
    public function __call(string $section, array $arguments): SectionInterface
    {
        $suffix = $arguments[0] ?? null;

        if (!array_key_exists($section, Section::RELATIONS)) {
            throw new InvalidArgumentException('Required section "' . $section . '" is not allowed');
        }

        return $this->section($section, $suffix);
    }

    /**
     * Generate L2TP configuration by parameters from memory
     *
     * @return string
     * @throws \RuntimeException If was set bad configuration
     */
    public function generate(): string
    {
        $generator = new Generator($this);

        return $generator->generate();
    }
}
