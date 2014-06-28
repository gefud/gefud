<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 28.06.14
 * Time: 11:24
 */

namespace Notilio\DDx\Generator;


use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Dumper;

class EntityPropertyGenerator extends GeneratorAware
{
    private $name;
    private $type;
    private $visibility;
    const DEFAULT_VISIBILITY = 'private';

    public function __construct($name, $type, $visibility = self::DEFAULT_VISIBILITY)
    {
        $this->name = $name;
        $this->type = $type;
        $this->visibility = $visibility;
    }

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

    public static function createFromArray(array $variablesArray)
    {
        $properties = [];
        foreach ($variablesArray as $variable) {
            $visibility = array_key_exists('visibility', $variable) ? $variable['visibility'] : self::DEFAULT_VISIBILITY;
            $property = new self($variable['name'], $variable['type'], $visibility);
            $properties[] = $property->create();
        }

        return $properties;
    }
} 