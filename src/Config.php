<?php

namespace XL2TP;

use BadMethodCallException;
use InvalidArgumentException;
use XL2TP\Interfaces\ConfigInterface;
use XL2TP\Interfaces\GeneratorInterface;
use XL2TP\Interfaces\SectionInterface;
use XL2TP\Interfaces\Sections\GlobalInterface;
use XL2TP\Interfaces\Sections\LacInterface;
use XL2TP\Interfaces\Sections\LnsInterface;

/**
 * Class Config
 *
 * @property GlobalInterface $global
 * @property LnsInterface    $lns
 * @property LacInterface    $lac
 * @method   GlobalInterface global()
 * @method   LnsInterface    lns(string $suffix = null)
 * @method   LacInterface    lac(string $suffix = null)
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
     * @return SectionInterface
     * @throws InvalidArgumentException
     */
    public function section(string $section, string $suffix = null): SectionInterface
    {
        if (empty($suffix) && mb_strtolower(trim($section)) !== 'global') {
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
     * @return SectionInterface
     * @throws InvalidArgumentException
     */
    public function __get(string $name)
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
     * @return SectionInterface
     */
    public function __call(string $section, array $arguments)
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
     */
    public function generate(): string
    {
        $generator = new Generator($this);
        return $generator->generate();
    }
}
