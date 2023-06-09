<?php

namespace atoum\atoum\tests\units\asserters;

use atoum\atoum;
use atoum\atoum\asserter;
use atoum\atoum\tools\variable;

require_once __DIR__ . '/../../runner.php';

class castToArray extends atoum\test
{
    public function testClass()
    {
        $this->testedClass->extends(atoum\asserters\phpArray::class);
    }

    public function test__construct()
    {
        $this
            ->given($this->newTestedInstance)
            ->then
                ->object($this->testedInstance->getGenerator())->isEqualTo(new asserter\generator())
                ->object($this->testedInstance->getAnalyzer())->isEqualTo(new variable\analyzer())
                ->object($this->testedInstance->getLocale())->isEqualTo(new atoum\locale())
                ->variable($this->testedInstance->getValue())->isNull()
                ->boolean($this->testedInstance->wasSet())->isFalse()

            ->given($this->newTestedInstance($generator = new atoum\asserter\generator(), $analyzer = new variable\analyzer(), $locale = new atoum\locale()))
            ->then
                ->object($this->testedInstance->getGenerator())->isIdenticalTo($generator)
                ->object($this->testedInstance->getAnalyzer())->isIdenticalTo($analyzer)
                ->object($this->testedInstance->getLocale())->isIdenticalTo($locale)
                ->variable($this->testedInstance->getValue())->isNull()
                ->boolean($this->testedInstance->wasSet())->isFalse()
        ;
    }

    public function testSetWith()
    {
        $this
            ->given(
                $adapter = new atoum\test\adapter(),
                $asserter = $this->newTestedInstance
                    ->setLocale($locale = new \mock\atoum\atoum\locale())
                    ->setAnalyzer($analyzer = new \mock\atoum\atoum\tools\variable\analyzer())
                    ->setAdapter($adapter)
            )
            ->then
                ->object($asserter->setWith($object = new \arrayiterator()))->isIdenticalTo($asserter)
                ->array($asserter->getValue())->isEqualTo((array) $object)

                ->object($asserter->setWith($object = new \arrayiterator()))->isIdenticalTo($asserter)
                ->array($asserter->getValue())->isEqualTo((array) $object)

            ->if(
                $adapter->str_split = false,
                $this->calling($locale)->_ = $notAnObject = uniqid(),
                $this->calling($analyzer)->getTypeOf = $type = uniqid()
            )
            ->then
                ->exception(function () use ($asserter, & $value) {
                    $asserter->setWith($value = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($notAnObject)
                    ->string($asserter->getValue())->isEqualTo($value)
                ->mock($locale)->call('_')->withArguments('%s could not be converted to array', $type)->once
                ->mock($analyzer)->call('getTypeOf')->withArguments($value)->once
        ;
    }

    public function testToString()
    {
        $this
            ->given($asserter = $this->newTestedInstance(new asserter\generator()))

            ->if($asserter->setWith($object = new \exception()))
            ->then
                ->castToString($asserter)->isEqualTo('array(' . count((array) $object) . ')')
        ;
    }
}
