<?php
/**
 * Gefud
 *
 * @copyright   Copyright (c) 2014, Michał Brzuchalski
 * @license     http://opensource.org/licenses/MIT
 * @author      Michał Brzuchalski <michal.brzuchalski@gmail.com>
 */
namespace Gefud\Generator;

use Mandango\Mondator\Dumper;

abstract class GeneratorAware implements GeneratorInterface
{
    public function generate()
    {
        $definition = $this->create();
        $dumper = new Dumper($definition);

        return $dumper->dump();
    }
} 