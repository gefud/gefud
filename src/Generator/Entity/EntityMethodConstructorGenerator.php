<?php
/**
 * Gefud
 *
 * @copyright   Copyright (c) 2014, Michał Brzuchalski
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski <michal.brzuchalski@gmail.com>
 */
namespace Gefud\Generator\Entity;

use Gefud\Helper\Variable;
use Gefud\Helper\VariableCollection;
use Gefud\Generator\GeneratorAware;
use Mandango\Mondator\Definition\Method;

class EntityMethodConstructorGenerator extends GeneratorAware
{
    private $className;
    private $variableCollection = array();

    public function __construct($className, VariableCollection $variableCollection)
    {
        $this->className = $className;
        $this->variableCollection = $variableCollection;
    }

    /**
     * @return Method
     */
    public function create()
    {
        $arguments = [];
        $code = '';
        $docComment = <<<EOF
    /**
     * {$this->className} entity constructor
     *

EOF;
        /** @var Variable $variable */
        foreach ($this->variableCollection as $variable) {
            if ($variable->isScalarType() || $variable->isUnknownType()) {
                $arguments[] = '$' . $variable->getName();
            } else {
                $arguments[] = $variable->getType() . ' $' . $variable->getName();
            }
            $code .= <<<EOF
        \$this->${variable['name']} = \$${variable['name']};

EOF;
            $ucName = ucfirst($variable['name']);
            $docComment .= <<<EOF
     * @param ${variable['type']} \$${variable['name']} $ucName value

EOF;
        }
        $constructor = new Method('public', '__construct', implode(', ', $arguments), $code);
        $constructor->setDocComment($docComment . <<<EOF
     */
EOF
        );

        return $constructor;
    }
} 
