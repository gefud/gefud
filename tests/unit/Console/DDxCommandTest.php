<?php
/**
 * DDx
 *
 * @copyright   Copyright (c) 2014, Notilio (notilio.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski(m.brzuchalski@notilio.com>
 */

namespace Notilio\DDx\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @package    Notilio\DDx\TestGenerator
 */
class DDxCommandTest extends \PHPUnit_Framework_TestCase
{
    const VALID_REACT_TYPE = 'dto';
    const INVALID_REACT_TYPE = 'notavailable';
    const VALID_FULLY_QUALIFIED_CLASSNAME = 'SludgeCo\Acid\BurnyDTO';
    const VALID_VARIABLE = 'string:name';
    const VALID_VARIABLE_TWO = 'int:burnLevel';

    /**
     * @test
     * @group entity-generator
     * @group entity-generator-console
     * @expectedException \RuntimeException
     */
    public function throwExceptionForNoType()
    {
        $application = new Application();
        $application->add(new DDxCommand());
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
        $application->add(new DDxCommand());
        $command = $application->find('entity:generate');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array('command' => $command->getName(), 'fqcn'=> self::VALID_FULLY_QUALIFIED_CLASSNAME)
        );
    }
}
