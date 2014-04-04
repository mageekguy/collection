<?php

namespace mageekguy\collection;

class collection implements \countable, \arrayAccess, definition
{
	private $elements = array();

	public function __construct() {}

	public function __invoke(callable $callback)
	{
		return $this->apply($callback);
	}

	public function count()
	{
		return sizeof($this->elements);
	}

	public function offsetGet($key)
	{
		return (isset($this->elements[$key]) === false ? null : $this->elements[$key]);
	}

	public function offsetSet($key, $element)
	{
		return $this->add($element, $key);
	}

	public function offsetUnset($key)
	{
		if (isset($this->elements[$key]) === true)
		{
			unset($this->elements[$key]);
		}

		return $this;
	}

	public function offsetExists($key)
	{
		return (isset($this->elements[$key]) === true);
	}

	public function reset()
	{
		$this->elements = array();

		return $this;
	}

	public function add($element, $key = null)
	{
		if ($key === null)
		{
			$this->elements[] = $element;
		}
		else
		{
			$this->elements[$key] = $element;
		}

		return $this;
	}

	public function fillWith(definition $collection)
	{
		return $this->fillWithArray($collection->toArray());
	}

	public function fillWithArray(array $array)
	{
		$this->elements = $array;

		return $this;
	}

	public function toArray()
	{
		return $this->elements;
	}

	public function select(callable $condition, $limit = null, callable $notFoundCallback = null)
	{
		$collection = new static();

		foreach ($this->elements as $key => $element)
		{
			if ($condition($element, $key) === true)
			{
				$collection->add($element, $key);

				if ($limit !== null && --$limit <= 0)
				{
					break;
				}
			}
		}

		if ($notFoundCallback !== null && sizeof($collection) <= 0)
		{
			$notFoundCallback();
		}

		return $collection;
	}

	public function delete(callable $condition, $limit = null, callable $notFoundCallback = null)
	{
		$collection = new static();

		$deletedElements = 0;

		foreach ($this->elements as $key => $element)
		{
			if ($limit !== null && $deletedElements >= $limit || $condition($element, $key) === false)
			{
				$collection->add($element, $key);
			}
			else
			{
				$deletedElements++;
			}
		}

		if ($deletedElements === 0 && $notFoundCallback !== null)
		{
			$notFoundCallback();
		}

		return $collection;
	}

	public function apply(callable $callable)
	{
		array_walk($this->elements, $callable);

		return $this;
	}
}
