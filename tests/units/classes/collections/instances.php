<?php

namespace mageekguy\collection\tests\units\collections;

require __DIR__ . '/../../runner.php';

use
	atoum
;

class instances extends atoum
{
	public function testClass()
	{
		$this->testedClass->extends('mageekguy\collection\collections\objects');
	}

	public function testAdd($class)
	{
		$this
			->given($this->newTestedInstance($class))
			->then
				->exception(function() { $this->testedInstance->add(new \mock\foo()); })
					->isInstanceOf('mageekguy\collection\collections\instances\exception')
					->hasMessage('object should be an instance of \\' . trim($class))

				->object($this->testedInstance->add(new \stdClass()))->isTestedInstance

				->object($this->testedInstance->add(new \mock\stdClass()))->isTestedInstance
		;
	}

	public function testSelectInstance()
	{
		$this
			->given($this->newTestedInstance('stdClass'))
			->then
				->object($this->testedInstance->selectInstance(new \stdClass()))
					->isEqualTo($this->newInstance('stdClass'))

			->if($this->testedInstance->fillWithArray([ $object1 = new \stdClass(), $object2 = new \stdClass(), $object3 = new \stdClass() ]))
			->then
				->object($this->testedInstance->selectInstance($object2))
					->isEqualTo($this->newInstance('stdClass')->fillWithArray([ 1 => $object2 ]))

				->object($this->testedInstance->selectInstance(clone $object2))
					->isEqualTo($this->newInstance('stdClass'))

				->object($this->testedInstance->selectInstance(new \stdClass(), function() use (& $flag) { $flag = true; }))
					->isEqualTo($this->newInstance('stdClass'))
					->boolean($flag)->isTrue
		;
	}

	protected function testAddDataProvider()
	{
		return [ 'stdclass', 'stdClass', '\sTdclAss' ];
	}
}
