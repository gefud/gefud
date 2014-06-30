<?php
/**
 * Gefud
 *
 * @copyright   Copyright (c) 2014, Michał Brzuchalski
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski(michal.brzuchalski@gmail.com>
 */
namespace Gefud\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @package    Gefud\Console
 */
class GenerateEntityCommandTest extends \PHPUnit_Framework_TestCase
{
    const VALID_REACT_TYPE = 'dto';
    const INVALID_REACT_TYPE = 'notavailable';
    const VALID_FULLY_QUALIFIED_CLASSNAME = 'Test\Entity\Employee';
    const VALID_VARIABLE = 'name:string';
    const VALID_VARIABLE_TWO = 'burnLevel:int';

    /**
     * @test
     * @group entity-generator
     * @group entity-generator-console
     * @expectedException \RuntimeException
     */
    public function throwExceptionForNoType()
    {
        $application = new Application();
        $application->add(new GefudEntityGenerateCommand());
        $command = $application->find('entity:generate');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array('command' => $command->getName())
        );
    }

    /**
     * @test
     * @group entity-generator
     * @group entity-generator-console
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Missed variable argument
     */
    public function throwExceptionForNotExistingVariableArgument()
    {
        $application = new Application();
        $application->add(new GefudEntityGenerateCommand());
        $command = $application->find('entity:generate');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array('command' => $command->getName(), 'fqcn'=> self::VALID_FULLY_QUALIFIED_CLASSNAME)
        );
    }
}
