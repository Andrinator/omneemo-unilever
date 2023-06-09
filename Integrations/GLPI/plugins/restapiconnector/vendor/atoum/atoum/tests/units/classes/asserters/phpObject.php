<?php

namespace atoum\atoum\tests\units\asserters;

use atoum\atoum;
use atoum\atoum\asserter;
use atoum\atoum\tools\variable;

require_once __DIR__ . '/../../runner.php';

class phpObject extends atoum\test
{
    public function testClass()
    {
        $this->testedClass->isSubclassOf(atoum\asserters\variable::class);
    }

    public function test__construct()
    {
        $this
            ->if($this->newTestedInstance)
                ->object($this->testedInstance->getGenerator())->isEqualTo(new asserter\generator())
                ->object($this->testedInstance->getAnalyzer())->isEqualTo(new variable\analyzer())
                ->object($this->testedInstance->getLocale())->isEqualTo(new atoum\locale())
                ->variable($this->testedInstance->getValue())->isNull()
                ->boolean($this->testedInstance->wasSet())->isFalse()

            ->if($this->newTestedInstance($generator = new asserter\generator(), $analyzer = new variable\analyzer(), $locale = new atoum\locale()))
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
            ->given($asserter = $this->newTestedInstance)

            ->if(
                $asserter->setLocale($locale = new \mock\atoum\atoum\locale()),
                $this->calling($locale)->_ = $isNotAnObject = uniqid()
            )
            ->then
                ->exception(function () use ($asserter, & $value) {
                    $asserter->setWith($value = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($isNotAnObject)
                ->mock($locale)->call('_')->withArguments('%s is not an object', $asserter)->once
                ->string($asserter->getValue())->isEqualTo($value)

                ->object($asserter->setWith($value = $this))->isIdenticalTo($asserter)
                ->object($asserter->getValue())->isIdenticalTo($value)

                ->object($asserter->setWith($value = uniqid(), false))->isIdenticalTo($asserter)
                ->string($asserter->getValue())->isEqualTo($value)
        ;
    }

    public function testHasSize()
    {
        $this
            ->if($asserter = $this->newTestedInstance($generator = new asserter\generator()))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->hasSize(rand(0, PHP_INT_MAX));
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Object is undefined')

            ->if($asserter->setWith($this))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->hasSize(0);
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage(sprintf($generator->getLocale()->_('%s has size %d, expected size %d'), $asserter, count($this), 0))
                ->exception(function () use ($asserter, & $failMessage) {
                    $asserter->hasSize(0, $failMessage = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($failMessage)
                ->object($asserter->hasSize(count($this)))->isIdenticalTo($asserter);
        ;
    }

    public function testIsEmpty()
    {
        $this
            ->if($asserter = $this->newTestedInstance($generator = new asserter\generator()))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isEmpty();
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Object is undefined')
                ->exception(function () use ($asserter) {
                    $asserter->isEmpty;
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Object is undefined')

            ->if($asserter->setWith($this))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isEmpty();
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage(sprintf($generator->getLocale()->_('%s has size %d'), $asserter, count($this)))
                ->exception(function () use ($asserter, & $failMessage) {
                    $asserter->isEmpty($failMessage = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($failMessage)
                ->exception(function () use ($asserter) {
                    $asserter->isEmpty;
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage(sprintf($generator->getLocale()->_('%s has size %d'), $asserter, count($this)))

            ->if($asserter->setWith(new \arrayIterator()))
            ->then
                ->object($asserter->isEmpty())->isIdenticalTo($asserter)
                ->object($asserter->isEmpty)->isIdenticalTo($asserter)
        ;
    }

    public function testIsCloneOf()
    {
        $this
            ->given($asserter = $this->newTestedInstance)
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isCloneOf($asserter);
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Object is undefined')

            ->if(
                $asserter
                    ->setWith($test = $this)
                    ->setLocale($locale = new \mock\atoum\atoum\locale())
                    ->setAnalyzer($analyzer = new \mock\atoum\atoum\tools\variable\analyzer()),
                $this->calling($locale)->_ = $isNotClone = uniqid(),
                $this->calling($analyzer)->getTypeOf = $type = uniqid()
            )
            ->then
                ->exception(function () use ($asserter, $test) {
                    $asserter->isCloneOf($test);
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($isNotClone)
                ->mock($locale)->call('_')->withArguments('%s is not a clone of %s', $asserter, $type)->once

                ->exception(function () use ($asserter, $test, & $failMessage) {
                    $asserter->isCloneOf($test, $failMessage = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($failMessage)

            ->if($clonedTest = clone $test)
            ->then
                ->object($asserter->isCloneOf($clonedTest))->isTestedInstance
        ;
    }

    public function testIsTestedInstance()
    {
        $this
            ->if($asserter = $this->newTestedInstance($generator = new asserter\generator()))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isTestedInstance();
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Object is undefined')
                ->exception(function () use ($asserter) {
                    $asserter->isTestedInstance;
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Object is undefined')

            ->if($asserter->setWith($this->testedInstance))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isTestedInstance();
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Tested instance is undefined in the test')
                ->exception(function () use ($asserter) {
                    $asserter->isTestedInstance;
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Tested instance is undefined in the test')

            ->if(
                $asserter->setWithTest($test = new \mock\atoum\atoum\test()),
                $this->calling($test)->__get = $this->testedInstance
            )
            ->then
                ->object($asserter->isTestedInstance())->isIdenticalTo($asserter)
                ->object($asserter->isTestedInstance)->isIdenticalTo($asserter)

            ->if($asserter->setWith($notTestedInstance = new \stdClass()))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isTestedInstance();
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                ->exception(function () use ($asserter, & $failMessage) {
                    $asserter->isTestedInstance($failMessage = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($failMessage)
                ->exception(function () use ($asserter) {
                    $asserter->isTestedInstance;
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
        ;
    }

    public function testIsNotTestedInstance()
    {
        $this
            ->given($asserter = $this->newTestedInstance($generator = new asserter\generator()))

            ->exception(function () use ($asserter) {
                $asserter->isNotTestedInstance();
            })
                ->isInstanceOf(atoum\exceptions\logic::class)
                ->hasMessage('Object is undefined')

            ->if($asserter->setWith(clone $this->testedInstance))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isNotTestedInstance();
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Tested instance is undefined in the test')

            ->if(
                $asserter->setWithTest($test = new \mock\atoum\atoum\test()),
                $this->calling($test)->__get = $this->testedInstance
            )
            ->then
                ->object($asserter->isNotTestedInstance())->isIdenticalTo($asserter)

            ->if($asserter->setWith($this->testedInstance))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isNotTestedInstance();
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                ->exception(function () use ($asserter, & $failMessage) {
                    $asserter->isNotTestedInstance($failMessage = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($failMessage)
        ;
    }

    public function testIsInstanceOfTestedClass()
    {
        $this
            ->given($asserter = $this->newTestedInstance($generator = new asserter\generator()))

            ->exception(function () use ($asserter) {
                $asserter->isInstanceOfTestedClass();
            })
                ->isInstanceOf(atoum\exceptions\logic::class)
                ->hasMessage('Object is undefined')

            ->if($asserter->setWith(clone $this->testedInstance))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isInstanceOfTestedClass();
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Tested instance is undefined in the test')

            ->if(
                $asserter->setWithTest($test = new \mock\atoum\atoum\test()),
                $this->calling($test)->__get = $this->testedInstance,
                $this->calling($test)->getTestedClassName = get_class($this->testedInstance)
            )
            ->then
                ->object($asserter->isInstanceOfTestedClass())->isIdenticalTo($asserter)

            ->if($asserter->setWith($this))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->isInstanceOfTestedClass();
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                ->exception(function () use ($asserter, & $failMessage) {
                    $asserter->isInstanceOfTestedClass($failMessage = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($failMessage)
        ;
    }

    public function testToString()
    {
        $this
            ->if($asserter = $this->newTestedInstance(new asserter\generator()))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->toString();
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Object is undefined')
            ->if($asserter->setWith($this))
            ->then
                ->object($asserter->toString())->isInstanceOf(atoum\asserters\castToString::class)
        ;
    }

    public function testToArray()
    {
        $this
            ->if($asserter = $this->newTestedInstance(new asserter\generator()))
            ->then
                ->exception(function () use ($asserter) {
                    $asserter->toArray();
                })
                    ->isInstanceOf(atoum\exceptions\logic::class)
                    ->hasMessage('Object is undefined')
            ->if($asserter->setWith($this))
            ->then
                ->object($asserter->toArray())->isInstanceOf(atoum\asserters\castToArray::class)
        ;
    }

    public function testIsInstanceOf()
    {
        $this
            ->given($asserter = $this->newTestedInstance($generator = new asserter\generator()))

            ->exception(function () use ($asserter) {
                $asserter->isInstanceOf(uniqid());
            })
                ->isInstanceOf(atoum\exceptions\logic::class)
                ->hasMessage('Argument of ' . get_class($asserter) . '::isInstanceOf() must be a class instance or a class name')

            ->exception(function () use ($asserter) {
                $asserter->isInstanceOf(\stdClass::class);
            })
                ->isInstanceOf(atoum\exceptions\logic::class)
                ->hasMessage('Object is undefined')

            ->if(
                $asserter
                    ->setWith($test = $this)
                    ->setLocale($locale = new \mock\atoum\atoum\locale())
                    ->setAnalyzer($analyzer = new \mock\atoum\atoum\tools\variable\analyzer()),
                $this->calling($locale)->_ = $isNotAnInstance = uniqid(),
                $this->calling($analyzer)->getTypeOf = $type = uniqid()
            )
            ->then
                ->exception(function () use ($asserter, $test) {
                    $asserter->isInstanceOf(\stdClass::class);
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($isNotAnInstance)
                ->mock($locale)->call('_')->withArguments('%s is not an instance of %s', $asserter, \stdClass::class)->once

                ->exception(function () use ($asserter, & $object) {
                    $asserter->isInstanceOf($object = new \stdClass());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($isNotAnInstance)
                ->mock($locale)->call('_')->withArguments('%s is not an instance of %s', $asserter, $type)->once
                ->mock($analyzer)->call('getTypeOf')->withArguments($object)->once

                ->exception(function () use ($asserter, & $otherObject, & $failMessage) {
                    $asserter->isInstanceOf($otherObject = new \stdClass(), $failMessage = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($failMessage)
                ->mock($analyzer)->call('getTypeOf')->withArguments($otherObject)->once

                ->object($asserter->isInstanceOf(get_class($test)))->isIdenticalTo($asserter)
                ->object($asserter->isInstanceOf('\\' . get_class($test)))->isIdenticalTo($asserter)
                ->object($asserter->isInstanceOf($test))->isIdenticalTo($asserter)
        ;
    }

    public function testIsNotInstanceOf()
    {
        $this
            ->given($asserter = $this->newTestedInstance($generator = new asserter\generator()))

            ->exception(function () use ($asserter) {
                $asserter->isNotInstanceOf(uniqid());
            })
                ->isInstanceOf(atoum\exceptions\logic::class)
                ->hasMessage('Argument of ' . get_class($asserter) . '::isNotInstanceOf() must be a class instance or a class name')

            ->exception(function () use ($asserter) {
                $asserter->isNotInstanceOf('stdClass');
            })
                ->isInstanceOf(atoum\exceptions\logic::class)
                ->hasMessage('Object is undefined')

            ->if(
                $asserter
                    ->setWith($test = $this)
                    ->setLocale($locale = new \mock\atoum\atoum\locale())
                    ->setAnalyzer($analyzer = new \mock\atoum\atoum\tools\variable\analyzer()),
                $this->calling($locale)->_ = $isAnInstance = uniqid(),
                $this->calling($analyzer)->getTypeOf = $type = uniqid()
            )
            ->then
                ->exception(function () use ($asserter, $test) {
                    $asserter->isNotInstanceOf($test);
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($isAnInstance)
                ->mock($locale)->call('_')->withArguments('%s is an instance of %s', $asserter, $type)->once

                ->exception(function () use ($asserter, $test) {
                    $asserter->isNotInstanceOf(get_class($test));
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($isAnInstance)
                ->mock($locale)->call('_')->withArguments('%s is an instance of %s', $asserter, get_class($test))->once

                ->exception(function () use ($asserter, $test) {
                    $asserter->isNotInstanceOf('\\' . get_class($test));
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($isAnInstance)
                ->mock($locale)->call('_')->withArguments('%s is an instance of %s', $asserter, '\\' . get_class($test))->once

                ->exception(function () use ($asserter, $test, & $failMessage) {
                    $asserter->isNotInstanceOf($test, $failMessage = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($failMessage)

                ->object($asserter->isNotInstanceOf('stdClass'))->isIdenticalTo($asserter)
                ->object($asserter->isNotInstanceOf('\stdClass'))->isIdenticalTo($asserter)
                ->object($asserter->isNotInstanceOf(new \stdClass()))->isIdenticalTo($asserter)
        ;
    }
}
