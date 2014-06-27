<?php
namespace Notilio\DDx\Generator;

use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Dumper;

class EntityGenerator
{
    private $className;
    private $nameSpace;
    private $variablesArray = [];

    public function __construct($className, $nameSpace, $variablesArray)
    {
	$this->className = $className;
	$this->nameSpace = $nameSpace;
	$this->variablesArray = $variablesArray;
    }

    public function generate()
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

	$dumper = new Dumper($definition);
	return $dumper->dump();
    }

    private function extractProperties()
    {
	$properties = [];
	foreach ($this->variablesArray as $name => $type) {
	    $property = new Property('private', $name, null);
	    $property->setDocComment(<<<EOF
    /**
     * @var $type
     */
EOF
);
	    $properties[] = $property;
	}
	return $properties;
    }

    private function extractMethods()
    {
	$methods = [];
	$methods[] = $this->createConstructor();
	foreach ($this->variablesArray as $name => $type) {
	    $methods[] = $this->createGetter($name, $type);
	    if ($name == 'id') {
		continue;
	    }
	    $methods[] = $this->createSetter($name, $type);
	}
        return $methods;
    }

    private function createConstructor()
    {
	$arguments = [];
	$code = '';
	$docComment = <<<EOF
    /**
     * {$this->className} entity constructor
     *

EOF;
	foreach ($this->variablesArray as $name => $type) {
	    // Setting argument name
	    $arguments[] = '$' . $name;
	    // Setting code
	    $code .= <<<EOF
        \$this->$name = $$name;

EOF;
	    // Setting parameter doc comment
	    $ucName = ucfirst($name);
	    $docComment .= <<<EOF
     * @param $type $$name $ucName value

EOF;
	}
	$constructor = new Method('public', '__construct', implode(', ', $arguments), $code);
	$constructor->setDocComment($docComment . <<<EOF
     */
EOF
);
	return $constructor;
    }

    private function createGetter($name, $type)
    {
	$ucName = ucfirst($name);
	$getter = new Method('public', 'get' . $ucName, '', <<<EOF
        return $$name;
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
