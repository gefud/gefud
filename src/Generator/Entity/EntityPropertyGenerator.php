<?php
/**
 * DDx
 *
 * @copyright   Copyright (c) 2014, Michał Brzuchalski
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski <m.brzuchalski@notilio.com>
 */
namespace DDx\Generator\Entity;

use DDx\Helper\Variable;
use DDx\Helper\VariableCollection;
use Mandango\Mondator\Definition\Property;
use DDx\Generator\GeneratorAware;

/**
 * Class EntityPropertyGenerator provides creation of DDD entity->property snippet
 * @package DDx\Generator\Entity
 */
class EntityPropertyGenerator extends GeneratorAware
{
    /**
     * @var string Property name
     */
    private $name;
    /**
     * @var string Value type
     */
    private $type;
    /**
     * @var string Property visibility
     */
    private $visibility;

    /**
     * Default property visibility
     */
    const DEFAULT_VISIBILITY = 'private';

    /**
     * Property snippet generator contructor
     * @param string $name Property name
     * @param string $type Value type
     * @param string $visibility Property visibility
     */
    public function __construct($name, $type, $visibility = self::DEFAULT_VISIBILITY)
    {
        $this->name = $name;
        $this->type = $type;
        $this->visibility = $visibility;
    }

    /**
     * Creates property object
     * @return Property
     */
    public function create()
    {
        $property = new Property($this->visibility, $this->name, null);
        $property->setDocComment(<<<EOF
    /**
     * @var {$this->type}
     */
EOF
        );

        return $property;
    }

    /**
     * Batch create of properties from variables array
     * @param VariableCollection $variableCollection Array of variable definition
     * @return array Array of created properties
     */
    public static function createFromCollection(VariableCollection $variableCollection)
    {
        $properties = [];
        /** @var Variable $variable */
        foreach ($variableCollection as $variable) {
            $property = new self($variable->getName(), $variable->getType(), $variable->getVisibility());
            $properties[] = $property->create();
        }

        return $properties;
    }
} 
