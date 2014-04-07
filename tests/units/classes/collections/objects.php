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
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->selectInstance(new \stdClass()))
					->isEqualTo($this->newInstance)

			->if($this->testedInstance->fillWithArray([ $object1 = new \stdClass(), $object2 = new \stdClass(), $object3 = new \stdClass() ]))
			->then
				->object($this->testedInstance->selectInstance($object2))
					->isEqualTo($this->newInstance->fillWithArray([ 1 => $object2 ]))

				->object($this->testedInstance->selectInstance(clone $object2))
					->isEqualTo($this->newInstance)

				->object($this->testedInstance->selectInstance(new \stdClass(), function() use (& $flag) { $flag = true; }))
					->isEqualTo($this->newInstance)
					->boolean($flag)->isTrue
		;
	}
}
