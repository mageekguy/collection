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

		$this->deleteIn(function($object) use ($element) { return $element === $object; });

		return parent::add($element, $key);
	}
}
