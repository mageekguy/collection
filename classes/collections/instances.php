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

	public function select(callable $condition, $limit = null, callable $notFoundCallback = null)
	{
		return (new static($this->class))->doSelect($this, $condition, $limit, $notFoundCallback);
	}

	public function delete(callable $condition, $limit = null, callable $notFoundCallback = null)
	{
		return (new static($this->class))->doDelete($this, $condition, $limit, $notFoundCallback);
	}
}
