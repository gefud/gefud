## DDx - Domain Driven Design element generator

**Current Build Status**
[![Build Status](http://ci.brzuchalski.net/build-status/image/3?branch=master)](http://ci.brzuchalski.net/build-status/view/3?branch=master)

##Getting started

1. Clone this repo `git clone git@gitlab.brzuchalski.net:ddx/ddx.git`
2. Run [composer](http://getcomposer.org/) install

##Running tests

1. Run PHPSpec tests by defauolt with `bin/phpspec run`

##Usage

```
bin/ddx entity:generate "Test\Entity\Employee" id:int name:string surname:string
```
