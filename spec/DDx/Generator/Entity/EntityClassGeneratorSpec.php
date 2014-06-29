<?php

namespace spec\DDx\Generator\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EntityClassGeneratorSpec extends ObjectBehavior
{
    function let()
    {
        $className = 'Employee';
        $nameSpace = 'Test\\Entity';
        $variablesArray = [
            ['name' => 'id', 'type' => 'int'],
            ['name' => 'name', 'type' => 'string'],
        ];
        $this->beConstructedWith($className, $nameSpace, $variablesArray);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DDx\Generator\Entity\EntityClassGenerator');
    }

    function it_shoult_generate_generate_class_definition()
    {
        $this->create()->shouldBeAnInstanceOf('\Mandango\Mondator\Definition\Definition');
    }
}
