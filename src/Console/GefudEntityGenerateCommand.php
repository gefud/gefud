<?php
/**
 * Gefud
 *
 * @copyright   Copyright (c) 2014, Michał Brzuchalski
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski <michal.brzuchalski@gmail.com>
 */
namespace Gefud\Console;

use Gefud\Generator\Entity\EntityClassGenerator;
use Gefud\Helper\VariableCollection;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * @package    DTOx\TestGenerator
 */
class GefudEntityGenerateCommand extends Command
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
            )
            ->addOption(
                'file',
                null,
                InputOption::VALUE_OPTIONAL,
                'Specify destination file name'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $config = Yaml::parse('gefud.yml');
        $processor = new Processor();
        $configuration = new ProjectConfiguration();
        $processedConfiguration = $processor->processConfiguration(
            $configuration,
            [$config]
        );
        //print_r($processedConfiguration);die();
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
        $variableCollection = new VariableCollection();
        foreach ($variables as $variableString) {
            $variableCollection->addFromStringNotation($variableString);
        }
        if (count($variableCollection) == 0) {
            throw new Exception('Missed variable argument');
        }
        $generator = new EntityClassGenerator($className, $nameSpace, $variableCollection);
        $directory = getcwd() .'/'.$this->getPath($fqcn);
        if (is_dir($directory) && !is_writable($directory)) {
            throw new Exception(sprintf('The "%s" directory is not writable', $directory));
        }
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
	    // TODO: Implement file name customization
        file_put_contents($directory.'/'.$className.'.php', $generator->generate());
        return "Done!";
    }
}
