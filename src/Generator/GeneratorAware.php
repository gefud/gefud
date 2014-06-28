<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 28.06.14
 * Time: 11:45
 */

namespace Notilio\DDx\Generator;

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