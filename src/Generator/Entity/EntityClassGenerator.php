<?php
/**
 * Gefud
 *
 * @copyright   Copyright (c) 2014, Michał Brzuchalski
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski <michal.brzuchalski@gmail.com>
 */
namespace Gefud\Generator\Entity;

use Gefud\Helper\VariableCollection;
use Gefud\Generator\GeneratorAware;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;

class EntityClassGenerator extends GeneratorAware
{
    /**
     * @var string Entity class name
     */
    private $className;
    /**
     * @var string Entity name space
     */
    private $nameSpace;
    /**
     * @var VariableCollection Entity variables definition
     */
    private $variableCollection;

    public function __construct($className, $nameSpace, $variableCollection)
    {
        $this->className = $className;
        $this->nameSpace = $nameSpace;
        $this->variableCollection = $variableCollection;
    }

    public function create()
    {
        $definition = new Definition($this->className);
        $definition->setClass($this->nameSpace . '\\' . $this->className);
        $definition->setAbstract(true);

        $properties = $this->extractProperties();
        $definition->setProperties($properties);

        $methods = $this->extractMethods();
        $definition->setMethods($methods);

        $definition->addInterface('\Serializable');
        $definition->addMethod($this->createSerialize());
        $definition->addMethod($this->createUnserialize());

        return $definition;
    }

    private function extractProperties()
    {
        $properties = EntityPropertyGenerator::createFromCollection($this->variableCollection);
        return $properties;
    }

    private function extractMethods()
    {
        $methods = [];

        $constructor = new EntityMethodConstructorGenerator($this->className, $this->variableCollection);
        $methods[] = $constructor->create();

//        foreach ($this->variablesArray as $name => $type) {
//            $methods[] = $this->createGetter($name, $type);
//            if ($name == 'id') {
//            continue;
//            }
//            $methods[] = $this->createSetter($name, $type);
//        }
        return $methods;
    }

    private function createGetter($name, $type)
    {
        $ucName = ucfirst($name);
        $getter = new Method('public', 'get' . $ucName, '', <<<EOF
        return \$this->$name;
EOF
);
	    $getter->setDocComment(<<<EOF
    /**
     * Get $ucName value
     *
     * @return $type
     */
EOF
);
	    return $getter;
    }

    private function createSetter($name, $type)
    {
        $ucName = ucfirst($name);
        $setter = new Method('public', 'set' . $ucName, '$value', <<<EOF
        \$this->$name = \$value;
EOF
);
        $setter->setDocComment(<<<EOF
    /**
     * Set $ucName value
     *
     * @param $type \$name $ucName value to set
     */
EOF
);
        return $setter;
    }

    private function createSerialize()
    {
    	$serialize = new Method('public', 'serialize', '', <<<EOF
        // TODO: Implement generator
EOF
);
	    return $serialize;
    }

    private function createUnserialize()
    {
    	$unserialize = new Method('public', 'unserialize', '$data', <<<EOF
        // TODO: Implement generator
EOF
);
	    return $unserialize;
    }
}
