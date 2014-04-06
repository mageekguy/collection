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

	protected function testAddDataProvider()
	{
		return [ 'stdclass', 'stdClass', '\sTdclAss' ];
	}
}
