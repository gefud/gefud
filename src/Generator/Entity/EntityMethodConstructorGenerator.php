<?php
/**
 * DDx
 *
 * @copyright   Copyright (c) 2014, Michał Brzuchalski
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski <m.brzuchalski@notilio.com>
 */
namespace DDx\Generator\Entity;

use Mandango\Mondator\Definition\Method;
use DDx\Generator\GeneratorAware;

class EntityMethodConstructorGenerator extends GeneratorAware
{
    private $className;
    private $variablesArray = array();

    public function __construct($className, array $variablesArray)
    {
        $this->className = $className;
        $this->variablesArray = $variablesArray;
    }

    public function create()
    {
        $arguments = [];
        $code = '';
        $docComment = <<<EOF
    /**
     * {$this->className} entity constructor
     *

EOF;
        foreach ($this->variablesArray as $variable) {
            // Setting argument name
            $arguments[] = '$' . $variable['name'];
            // Setting code
            $code .= <<<EOF
        \$this->${variable['name']} = \$${variable['name']};

EOF;
            // Setting parameter doc comment
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