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

		$this->select(function($object) use ($element) { return $element === $object; }, null, function() use ($element) { $this->addParent($element); });

		return $this;
	}

	private function addParent($element, $key = null)
	{
		return parent::add($element, $key);
	}
}
