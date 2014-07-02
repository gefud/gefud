<?php

namespace spec\Gefud\Generator\Entity;

use Gefud\Helper\VariableCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EntityClassGeneratorSpec extends ObjectBehavior
{
    const CLASS_NAME = 'Employee';
    const NAME_SPACE = 'Test\\Entity';
    public static $variablesArray = [
        'id:int',
        'name:string',
    ];

    function let()
    {
        $variableCollection = new VariableCollection();
        foreach (self::$variablesArray as $variableString) {
            $variableCollection->addFromStringNotation($variableString);
        }
        $this->beConstructedWith(self::CLASS_NAME, self::NAME_SPACE, $variableCollection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Gefud\Generator\Entity\EntityClassGenerator');
    }

    function it_should_generate_class_definition_object()
    {
        $definition = $this->create();
        $definition->shouldBeAnInstanceOf('\Mandango\Mondator\Definition\Definition');
        $definition->getClassName()->shouldBe(self::CLASS_NAME);
        $definition->getNameSpace()->shouldBe(self::NAME_SPACE);
    }
}
