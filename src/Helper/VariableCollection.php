<?php
/**
 * Gefud
 *
 * @copyright   Copyright (c) 2014, Michał Brzuchalski
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski <michal.brzuchalski@gmail.com>
 */
namespace Gefud\Helper;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use InvalidArgumentException;

class VariableCollection implements IteratorAggregate, Countable
{
    /**
     * @var array Variables array
     */
    private $data = [];

    /**
     * Simple variable definition storage
     */
    public function __construct()
    {

    }

    /**
     * Adds variable to collection
     * @param string $name Variable name
     * @param string $type Variable type
     * @param null|mixed $value Variable value
     * @param null|string $visibility Variable visibility
     */
    public function add($name, $type, $value = null, $visibility = null)
    {
        $this->data[$name] = new Variable($name, $type, $value, $visibility);
    }

    /**
     * Adds variable to collection from string notation eg. "id:integer[:12[:public]]"
     * @param string $definition
     * @throws InvalidArgumentException When unknown wariable format given
     */
    public function addFromStringNotation($definition = '')
    {
        if (preg_match('/^(?<name>[^:]+):(?<type>[^:]+)(:(?<value>[^:]+)(:(?<visibility>[^:]+))?)?/', $definition, $match)) {
            $value = array_key_exists('value', $match) ? $match['value'] : null;
            $visibility = array_key_exists('visibility', $match) ? $match['visibility'] : null;
            $this->add($match['name'], $match['type'], $value, $visibility);
        } else {
            throw new InvalidArgumentException("Unknown variable definition format, given: $definition");
        }
    }

    /**
     * Gets array iterator for foreach language construct
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Gets defined variables count
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }
} 