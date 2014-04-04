<?php

namespace mageekguy\collection\tests\units;

require __DIR__ . '/../runner.php';

use
	atoum
;

class collection extends atoum
{
	public function testClass()
	{
		$this->testedClass
			->implements('countable')
			->implements('arrayAccess')
			->implements('mageekguy\collection\definition')
		;
	}

	public function test__invoke()
	{
		$this
			->given($collection = $this->newTestedInstance)
			->then
				->object($collection(function() {}))->isTestedInstance

			->if($collection->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->object($collection(function(& $element) { $element *= 2; }))->isTestedInstance
				->array($collection->toArray())->isEqualTo([ 2, 4, 6, 8, 10 ])

			->if($collection->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->object($collection(function($element) { return $element * 2; }))->isTestedInstance
				->array($collection->toArray())->isEqualTo([ 1, 2, 3, 4, 5 ])

			->if($collection->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->object($collection(function(& $element, $key) { $element *= $key; }))->isTestedInstance
				->array($collection->toArray())->isEqualTo([ 0, 2, 6, 12, 20 ])
		;
	}

	public function testCount()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->sizeof($this->testedInstance)->isZero
		;
	}

	public function testOffsetGet()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->variable($this->testedInstance->offsetGet(uniqid()))->isNull
				->variable($this->testedInstance[uniqid()])->isNull

			->if($this->testedInstance->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->variable($this->testedInstance->offsetGet(uniqid()))->isNull
				->variable($this->testedInstance[uniqid()])->isNull

				->variable($this->testedInstance->offsetGet(rand(5, PHP_INT_MAX)))->isNull
				->variable($this->testedInstance[rand(5, PHP_INT_MAX)])->isNull

				->integer($this->testedInstance->offsetGet(2))->isEqualTo(3)
				->integer($this->testedInstance[2])->isEqualTo(3)

			->if($this->testedInstance->fillWithArray([ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ]))
			->then
				->variable($this->testedInstance->offsetGet(uniqid()))->isNull
				->variable($this->testedInstance[uniqid()])->isNull

				->variable($this->testedInstance->offsetGet('f'))->isNull
				->variable($this->testedInstance['f'])->isNull

				->integer($this->testedInstance->offsetGet('c'))->isEqualTo(3)
				->integer($this->testedInstance['c'])->isEqualTo(3)
		;
	}

	public function testOffsetSet()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->offsetSet($key = uniqid(), $element = uniqid()))->isTestedInstance
				->string($this->testedInstance[$key])->isEqualTo($element)

			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->offsetSet(null, $element1 = uniqid()))->isTestedInstance
				->string($this->testedInstance[0])->isEqualTo($element1)

				->object($this->testedInstance->offsetSet(null, $element2 = uniqid()))->isTestedInstance
				->string($this->testedInstance[0])->isEqualTo($element1)
				->string($this->testedInstance[1])->isEqualTo($element2)

				->object($this->testedInstance->offsetSet(5, $element3 = uniqid()))->isTestedInstance
				->string($this->testedInstance[0])->isEqualTo($element1)
				->string($this->testedInstance[1])->isEqualTo($element2)
				->string($this->testedInstance[5])->isEqualTo($element3)
		;
	}

	public function testOffsetUnset()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->offsetUnset(uniqid()))->isTestedInstance

			->if($this->testedInstance->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->when(function() { unset($this->testedInstance[2]); })
				->then
					->array($this->testedInstance->toArray())->isEqualTo([ 0 => 1, 1 => 2, 3 => 4, 4 => 5 ])

			->if($this->testedInstance->fillWithArray([ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ]))
			->then
				->when(function() { unset($this->testedInstance['c']); })
				->then
					->array($this->testedInstance->toArray())->isEqualTo([ 'a' => 1, 'b' => 2, 'd' => 4, 'e' => 5 ])
		;
	}

	public function testOffsetExists()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->boolean($this->testedInstance->offsetExists(uniqid()))->isFalse

			->if($this->testedInstance->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->boolean($this->testedInstance->offsetExists(rand(5, PHP_INT_MAX)))->isFalse
				->boolean(isset($this->testedInstance[rand(5, PHP_INT_MAX)]))->isFalse

				->boolean($this->testedInstance->offsetExists(rand(0, 4)))->isTrue
				->boolean(isset($this->testedInstance[rand(0, 4)]))->isTrue

			->if($this->testedInstance->fillWithArray([ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ]))
			->then
				->boolean($this->testedInstance->offsetExists('f'))->isFalse
				->boolean(isset($this->testedInstance['f']))->isFalse

				->boolean($this->testedInstance->offsetExists('c'))->isTrue
				->boolean(isset($this->testedInstance['c']))->isTrue
		;
	}

	public function testReset()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->reset())->isTestedInstance

			->if($this->testedInstance->add(uniqid()))
			->then
				->object($this->testedInstance->reset())->isTestedInstance
				->sizeof($this->testedInstance)->isZero
		;
	}

	public function testAdd()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->add($value1 = uniqid()))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo([ $value1 ])

				->object($this->testedInstance->add($value1))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo([ $value1, $value1 ])

				->object($this->testedinstance->add($value2 = uniqid()))->istestedinstance
				->array($this->testedinstance->toarray())->isequalto([ $value1, $value1, $value2 ])

				->object($this->testedinstance->add($value2, 0))->istestedinstance
				->array($this->testedinstance->toarray())->isequalto([ $value2, $value1, $value2 ])
		;
	}

	public function testToArray()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->array($this->testedInstance->toArray())->isEmpty

			->if($this->testedInstance->add($value1 = uniqid()))
			->then
				->array($this->testedInstance->toArray())->isEqualTo([ $value1 ])

			->if($this->testedInstance->add($value2 = uniqid()))
			->then
				->array($this->testedInstance->toArray())->isEqualTo([ $value1, $value2 ])
		;
	}

	public function testFillWith()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->fillWith($this->newInstance))->isTestedInstance
				->sizeof($this->testedInstance)->isZero

				->object($this->testedInstance->fillWith($this->newInstance->fillWithArray($array = [ uniqid(), uniqid(), uniqid() ])))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo($array)
		;
	}

	public function testFillWithArray()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->fillWithArray($array = []))->isTestedInstance
				->sizeof($this->testedInstance)->isZero

				->object($this->testedInstance->fillWithArray($array = [ uniqid(), uniqid(), uniqid() ]))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo($array)
		;
	}

	public function testSelect()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->select(function() {}))
					->isEqualTo($this->testedInstance)

			->if($this->testedInstance->fillWithArray([ $value1 = uniqid(), $value2 = uniqid(), $value3 = uniqid() ]))
			->then
				->object($this->testedInstance->select(function($element) use ($value2) { return $element == $value2; }))
					->isEqualTo($this->newInstance->fillWithArray([ 1 => $value2 ]))

				->object($this->testedInstance->select(function($element, $key) { return $key == 2; }))
					->isEqualTo($this->newInstance->fillWithArray([ 2 => $value3 ]))

			->if($this->testedInstance->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->object($this->testedInstance->select(function($element) { return $element > 2; }, 2))
					->isEqualTo($this->newInstance->fillWithArray([ 2 => 3, 3 => 4 ]))

				->object($this->testedInstance->select(function($element) { return $element > 5; }, 2, function() use (& $flag) { $flag = true; }))
					->isEqualTo($this->newInstance)
					->boolean($flag)->isTrue
		;
	}

	public function testApply()
	{
		$this
			->given($this->newTestedInstance)
			->then
				->object($this->testedInstance->apply(function() {}))->isTestedInstance

			->if($this->testedInstance->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->object($this->testedInstance->apply(function(& $element) { $element *= 2; }))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo([ 2, 4, 6, 8, 10 ])

			->if($this->testedInstance->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->object($this->testedInstance->apply(function($element) { return $element * 2; }))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo([ 1, 2, 3, 4, 5 ])

			->if($this->testedInstance->fillWithArray([ 1, 2, 3, 4, 5 ]))
			->then
				->object($this->testedInstance->apply(function(& $element, $key) { $element *= $key; }))->isTestedInstance
				->array($this->testedInstance->toArray())->isEqualTo([ 0, 2, 6, 12, 20 ])
		;
	}
}
