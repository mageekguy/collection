<?php

namespace mageekguy\collection\tests\units\collections\instances;

require __DIR__ . '/../../../runner.php';

use
	atoum
;

class exception extends atoum
{
	public function testClass()
	{
		$this->testedClass->extends('mageekguy\collection\collections\objects\exception');
	}
}
