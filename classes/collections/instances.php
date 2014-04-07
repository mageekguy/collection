<?php

namespace mageekguy\collection\collections;

use
	mageekguy\collection
;

class instances extends objects
{
	private $class = '';

	public function __construct($class)
	{
		$this->class = $class;

		parent::__construct();
	}

	public function add($element, $key = null)
	{
		if ($element instanceof $this->class === false)
		{
			throw new instances\exception('object should be an instance of \\' . $this->class);
		}

		return parent::add($element, $key);
	}

	protected function doSelect(collection\collection $collection = null, callable $condition, $limit = null, callable $notFoundCallback = null)
	{
		return parent::doSelect($collection ?: new static($this->class), $condition, $limit, $notFoundCallback);
	}

	protected function doDelete(collection\collection $collection = null, callable $condition, $limit = null, callable $notFoundCallback = null)
	{
		return parent::doDelete($collection ?: new static($this->class), $condition, $limit, $notFoundCallback);
	}
}
