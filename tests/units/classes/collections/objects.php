<?php

namespace mageekguy\collection\tests\units\collections;

require __DIR__ . '/../../runner.php';

use
	atoum
;

class objects extends atoum
{
	public function testClass()
	{
		$this->testedClass->extends('mageekguy\collection\collection');
	}

	public function testAdd()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->add($object1 = new \stdClass()))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo([ $object1 ])

				->object($this->testedInstance->add($object1))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo([ $object1 ])

				->object($this->testedInstance->add($object2 = clone $object1))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo([ $object1, $object2 ])

				->object($this->testedInstance->add($object3 = new \mock\foo()))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo([ $object1, $object2, $object3 ])

				->exception(function() { $this->testedInstance->add(uniqid()); })
					->isInstanceOf('mageekguy\collection\collections\objects\exception')
					->hasMessage('Collection should contains only object')
		;
	}

	public function testSelectInstance()
	{
	}
}
