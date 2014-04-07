<?php

namespace mageekguy\collection\collections;

use
	mageekguy\collection
;

class objects extends collection\collection
{
	public function add($element, $key = null)
	{
		if (is_object($element) === false)
		{
			throw new objects\exception('Collection should contains only object');
		}

		$this->select(function($object) use ($element) { return $element === $object; }, null, function() use ($element, $key) { parent::add($element, $key); });

		return $this;
	}

	public function selectInstance($instance, callable $notFoundCallback = null)
	{
		return $this->doSelect(new static(), function($object) use ($instance) { return $object === $instance; }, null, $notFoundCallback);
	}
}
