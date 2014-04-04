<?php

namespace mageekguy\collection\tests\units\collections\objects;

require __DIR__ . '/../../../runner.php';

use
	atoum
;

class exception extends atoum
{
	public function testClass()
	{
		$this->testedClass
			->implements('mageekguy\collection\exception')
			->extends('runtimeException')
		;
	}
}
