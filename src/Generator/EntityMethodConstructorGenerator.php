<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 28.06.14
 * Time: 11:39
 */

namespace Notilio\DDx\Generator;

use Mandango\Mondator\Definition\Method;

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