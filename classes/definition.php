<?php

namespace mageekguy\collection;

interface definition
{
	public function __invoke(callable $callback);
	public function fillWith(definition $collection);
	public function fillWithArray(array $array);
	public function toArray();
	public function add($element, $key = null);
	public function select(callable $condition, $limit = null, callable $notFoundCallback = null);
	public function apply(callable $callback);
}
