<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace Notilio\DDx\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Notilio\DDx\Generator\EntityGenerator;
use Exception;

/**
 * @package    DTOx\TestGenerator
 */
class DDxCommand extends Command
{
    protected function configure()
    {
        $this->setName('entity:generate')
            ->setDescription('Start a new filled Entity snippet.')
            ->addArgument(
                'fqcn',
                InputArgument::REQUIRED,
                'Specify the fully qualified class name!'
            )
            ->addArgument(
                'variables',
                InputArgument::IS_ARRAY,
                'Specify your variables!'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');
        $className = $this->getClassName($input->getArgument('fqcn'));
        $path = $this->getPath($input->getArgument('fqcn'));
        $output->writeln("Creating a new entity called $className in $path...");
	$text = $this->generate($input->getArgument('fqcn'), $input->getArgument('variables'));
        $output->writeln($text);
    }

    private function getClassName($fqcn)
    {
        return array_pop(explode('\\', $fqcn));
    }

    private function getNameSpace($fqcn)
    {
        return implode('\\', array_slice(explode('\\', $fqcn), 0, count(explode('\\', $fqcn))-1));
    }

    private function getPath($fqcn)
    {
        return implode('/', array_slice(explode('\\', $fqcn), 0, count(explode('\\', $fqcn))-1));
    }

    private function generate($fqcn, $variables)
    {
        $className = $this->getClassName($fqcn);
        $nameSpace = $this->getNameSpace($fqcn);
        $variablesArray = array();
        foreach ($variables as $variableString) {
            $parts = explode(':', $variableString);
            $variablesArray[$parts[1]] = $parts[0];
        }
        if (sizeof($variablesArray) == 0) {
            throw new Exception('<error>Missed variable argument</error>');
        }
        $generator = new EntityGenerator($className, $nameSpace, $variablesArray);
        $directory = getcwd() .'/'.$this->getPath($fqcn);
        if (is_dir($directory) && !is_writable($directory)) {
            throw new Exception(sprintf('The "%s" directory is not writable', $directory));
        }
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        file_put_contents($directory.'/'.$className.'.php', $generator->generate());
        return "Done!";
    }
}
