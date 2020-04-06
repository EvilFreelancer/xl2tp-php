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
     * @param string|null $name Name of section
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
        if (!in_array($name, $this->allowed, true)) {
            throw new \InvalidArgumentException('Required section is not allowed here');
        }

        return $this->section($name);
    }

    /**
     * Magic method required for call of another classes
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return bool|object
     * @throws \ErrorException
     */
    public function __call(string $name, array $arguments)
    {
        // Set class name as namespace
        $class = $this->namespace . '\\' . $this->snakeToPascal($name) . 's';

        var_dump("[$class] has been called!");

        // Try to create object by name
        $object = new $class($this->config);

        // Call user function from endpoint class
        $func = call_user_func_array($object, $arguments);

        return $this->config->get('auto_exec') ? $func->exec() : $func;
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
