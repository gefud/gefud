## Gefud - Generator for Entities, Factories and their Usecases in Ddd

**Current Build Status**
[![Build Status](https://drone.io/github.com/gefud/gefud/status.png)](https://drone.io/github.com/gefud/gefud/latest)

##Getting started

1. Clone this repo `git clone git@guthub.com:gefud/gefud.git`
2. Run [composer](http://getcomposer.org/) install

##Running tests

1. Run PHPSpec tests by default with `bin/phpspec run`

##Usage

```
bin/gefud entity:generate "Test\Entity\Employee" id:int name:string surname:string
```

##TODO

1. Add generating unit tests for entities (cli accepts third parameter in variables as test value, eg. "name:string:Michał")
2. Add generating factories for entities
3. Add configuration throught gefud.yml with path for generated files and default namespace (shortens cli commands with namespace)
4. Add InMemory store generation
5. Add spec test generations with default store (eg. with InMemory)
6. Add behat test for cli execution
7. Add generation of specified framework stores (eg. Symfony2/Doctrine, Phalcon etc.)
