<?php
declare(strict_types=1);

namespace Butschster\Kraken\ValueObjects;

use BadMethodCallException;
use InvalidArgumentException;
use ReflectionClass;
use Stringable;
use Webmozart\Assert\Assert;

abstract class Enum implements Stringable
{
    protected string $value;
    private string $key;

    /**
     * Store existing constants in a static cache per object.
     * @var array
     */
    protected static array $cache = [];

    /**
     * Cache of instances of the Enum class
     * @var array
     */
    protected static array $instances = [];

    /**
     * Creates a new value of some type
     *
     * @param string $value
     * @throws InvalidArgumentException if incompatible type is given.
     */
    public function __construct(string $value)
    {
        $this->key = static::assertValidValueReturningKey($value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * Determines if Enum should be considered equal with the variable passed as a parameter.
     * Returns false if an argument is an object of different class or not an object.
     * This method is final, for more information read https://github.com/myclabs/php-enum/issues/4
     * @return bool
     */
    final public function equals(self $enum): bool
    {
        return $this->value() === $enum->value();
    }

    /**
     * Returns the names (keys) of all constants in the Enum class
     * @return array
     */
    public static function keys(): array
    {
        return array_keys(static::toArray());
    }

    /**
     * Returns instances of the Enum class of all Enum constants
     * @return static[] Constant name in key, Enum instance in value
     */
    public static function values(): array
    {
        $values = [];

        foreach (static::toArray() as $key => $value) {
            $values[$key] = new static($value);
        }

        return $values;
    }

    /**
     * Returns all possible values as an array
     * @return array Constant name in key, constant value in value
     * @throws \ReflectionException
     */
    protected static function toArray(): array
    {
        $class = static::class;

        if (!isset(static::$cache[$class])) {
            $reflection = new ReflectionClass($class);
            static::$cache[$class] = $reflection->getConstants();
        }

        return static::$cache[$class];
    }

    /**
     * Check if is valid enum value
     *
     * @param string $value
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        return \in_array($value, static::toArray(), true);
    }

    /**
     * Asserts valid enum value
     * @param mixed $value
     */
    public static function assertValidValue(string $value): void
    {
        self::assertValidValueReturningKey($value);
    }

    /**
     * Asserts valid enum value
     * @param mixed $value
     * @return string
     */
    private static function assertValidValueReturningKey(string $value): string
    {
        $key = static::search($value);
        Assert::notFalse($key, "Value '$value' is not part of the enum " . class_basename(static::class));

        return $key;
    }

    /**
     * Check if is valid enum key
     *
     * @param string $key
     * @return bool
     */
    public static function isValidKey(string $key): bool
    {
        $array = static::toArray();

        return isset($array[$key]) || array_key_exists($key, $array);
    }

    /**
     * Return key for value
     *
     * @param string $value
     * @throws \ReflectionException
     */
    public static function search(string $value): string|false
    {
        return array_search($value, static::toArray(), true);
    }

    /**
     * Returns a value when called statically like so: MyEnum::SOME_VALUE() given SOME_VALUE is a class constant
     *
     * @param string $name
     * @param array $arguments
     *
     * @return static
     * @throws BadMethodCallException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $class = static::class;
        if (!isset(self::$instances[$class][$name])) {
            $array = static::toArray();
            if (!isset($array[$name]) && !\array_key_exists($name, $array)) {
                $message = "No static method or enum constant '$name' in class " . static::class;
                throw new BadMethodCallException($message);
            }
            return self::$instances[$class][$name] = new static($array[$name]);
        }

        return clone self::$instances[$class][$name];
    }

    /**
     * This method exists only for the compatibility reason when deserializing a previously serialized version
     * that didn't had the key property
     */
    public function __wakeup()
    {
        if ($this->key === null) {
            $this->key = static::search($this->value);
        }
    }
}
