<?php

namespace XL2TP;

use InvalidArgumentException;
use XL2TP\Interfaces\SectionInterface;
use XL2TP\Interfaces\Sections\GlobalInterface;
use XL2TP\Interfaces\Sections\LacInterface;
use XL2TP\Interfaces\Sections\LnsInterface;

/**
 * Class Section
 *
 * @package XL2TP
 * @since   1.0.0
 */
class Section implements SectionInterface
{
    /**
     * Default name of section
     *
     * @var string
     */
    public $section = 'global';

    /**
     * Default suffix of section
     *
     * @var string
     */
    public $suffix = 'default';

    /**
     * List of preconfigured parameters
     *
     * @var array
     */
    public $parameters = [];

    /**
     * List of allowed parameters
     *
     * @var array
     */
    private $allowed;

    /**
     * Binding to allowed lists of parameters
     */
    public const RELATIONS = [
        'global' => GlobalInterface::class,
        'lns'    => LnsInterface::class,
        'lac'    => LacInterface::class,
    ];

    /**
     * Section constructor.
     *
     * @param string|null $section
     * @param string|null $suffix
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $section = null, string $suffix = null)
    {
        // Set section
        if (!empty($section) && mb_strtolower(trim($section)) !== 'global') {
            $this->section = mb_strtolower(trim($section));

            // Check if section is allowed
            if (!array_key_exists($section, self::RELATIONS)) {
                throw new InvalidArgumentException('Section "' . $section . '" is not allowed');
            }
        }

        // Set suffix
        if (!empty($suffix) && mb_strtolower(trim($suffix)) !== 'default') {
            $this->suffix = mb_strtolower(trim($suffix));
        }

        // Extract allowed list
        /** @var GlobalInterface|LnsInterface|LacInterface $allowed */
        $allowed       = self::RELATIONS[$this->section];
        $this->allowed = $allowed::ALLOWED;
    }

    /**
     * Check if section has provided parameter
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->parameters[$key]);
    }

    /**
     * Get value of section
     *
     * @param string $key
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function get(string $key): string
    {
        return $this->parameters[$key];
    }

    /**
     * Set parameter of section
     *
     * @param string      $key
     * @param string|null $value
     *
     * @return SectionInterface
     */
    public function set(string $key, string $value = null): SectionInterface
    {
        $key = Helpers::decamelize($key);
        if (!in_array($key, $this->allowed, true)) {
            throw new InvalidArgumentException('Parameter "' . $key . '" is not allowed');
        }

        // Unset empty value
        if (empty($value)) {
            $this->unset($key);
        } else {
            $this->parameters[$key] = $value;
        }

        return $this;
    }

    /**
     * Remove provided parameter
     *
     * @param string $key
     *
     * @return void
     */
    public function unset(string $key): void
    {
        unset($this->parameters[$key]);
    }

    /**
     * Alias to `->get()`
     *
     * @param string $key
     *
     * @return string
     */
    public function __get(string $key): string
    {
        return $this->get($key);
    }

    /**
     * Alias to `->has()`
     *
     * @param string $key
     *
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return $this->has($key);
    }

    /**
     * Alias to `->set()`
     *
     * @param string      $key
     * @param string|null $value
     */
    public function __set(string $key, string $value = null)
    {
        $this->set($key, $value);
    }
}
