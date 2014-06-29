<?php

namespace spec\DDx\Generator\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EntityClassGeneratorSpec extends ObjectBehavior
{
    const CLASS_NAME = 'Employee';
    const NAME_SPACE = 'Test\\Entity';
    public static $variablesArray = [
        ['name' => 'id', 'type' => 'int'],
        ['name' => 'name', 'type' => 'string'],
    ];

    function let()
    {
        $this->beConstructedWith(self::CLASS_NAME, self::NAME_SPACE, self::$variablesArray);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DDx\Generator\Entity\EntityClassGenerator');
    }

    function it_should_generate_generate_class_definition()
    {
        $definition = $this->create();
        $definition->shouldBeAnInstanceOf('\Mandango\Mondator\Definition\Definition');
        $definition->getClassName()->shouldBe(self::CLASS_NAME);
        $definition->getNameSpace()->shouldBe(self::NAME_SPACE);
    }
}
