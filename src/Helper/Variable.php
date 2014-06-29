<?php
/**
 * DDx
 *
 * @copyright   Copyright (c) 2014, Michał Brzuchalski
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski <m.brzuchalski@notilio.com>
 */
namespace DDx\Helper;

class Variable implements \ArrayAccess
{
    /**
     * @var string Variable name
     */
    private $name;
    /**
     * @var string Variable type
     */
    private $type;
    /**
     * @var mixed Variable value
     */
    private $value;
    /**
     * @var string Variable visibility
     */
    private $visibility;

    const DEFAULT_VISIBILITY = 'private';

    /**
     * Variable object constructor
     * @param string $name Variable name
     * @param string $type Variable type
     * @param mixed $value Variable value
     * @param string $visibility Variable visibility
     */
    public function __construct($name, $type, $value, $visibility)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->visibility = $visibility;
    }

    /**
     * Get variable name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get variable type
     * @return string
     */
    public function getType()
    {
        switch (strtolower($this->type)) {
            case 'int':
            case 'integer':
                return 'integer';

            case 'double':
            case 'decimal':
            case 'float':
                return 'float';

            case 'bool':
            case 'boolean':
                return 'boolean';

            case 'array':
                return 'array';

            default:
                if (class_exists($this->type)) {
                    return $this->type;
                } else {
                    return 'unknown';
                }
        }
    }

    /**
     * Check if variable is scalar type
     * @return bool
     */
    public function isScalarType()
    {
        $scalarTypes = ['integer', 'float', 'boolean', 'array'];
        return in_array($this->getType(), $scalarTypes);
    }

    /**
     * Get variable value
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get variable visibility
     * @return string
     */
    public function getVisibility()
    {
        $validVisibilities = ['private', 'protected', 'public'];
        $visibility = strtolower($this->visibility);
        if (in_array($visibility, $validVisibilities)) {
            return $visibility;
        } else {
            return self::DEFAULT_VISIBILITY;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (property_exists($this, $offset)) {
            $this->$offset = $value;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        throw new \LogicException("Variable properties cannot be unset, trying to unset: $offset property");
    }
}