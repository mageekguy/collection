# Collection

Collection is a PHP class allowing to select and apply a treatment on several elements in a more object-oriented way, i.e. in the 'tell, don't ask` manner.  
Usually, to apply a treatment on a collection of element, you do:

```php
foreach ($array as $element)
{
	if ($element->isTheRight())
	{
		$something->doSomethingOn($element);
	}
}
```

You can also use `array_walk` and `array_filter` but it's not the OOP way.
With Collection, you can do:

``` php
use mageekguy\collection\collection;

(new collection($array))
 	->select(function($element) { return $element->isTheRight(); })
		->apply(function($element) use ($something) { $something->doSomethingOn($element); });
```

So, you command the collection to select the right elements and apply a callback on each of them, instead of querying each element with `element::isTheRight()` to know if you should apply the method `something::doSomethingOn()` on it.  
Moreover, Collection allows you to limit the selection:

``` php
$collection = new collection($array);
$rightElements = $collection->select(function($element) { return $element->isTheRight(); }, 2); // only 2 elements will be selected even if the collection contains more matching elements
$rightElements(function($element) use ($something) { $something->doSomethingOn($element); }); // you can apply a callback with this syntaxic sugar.
```

And at last, you can define a callback if `collection::select()` return an empty collection:

``` php
$collection = new collection($array);
$collection->select(function($element) { return $element->isTheRight(); }, 2, function() { thow new exception('Unable to find any element matching this condition'); });
```

Collection supports `arrayAccess` interface, so you can use it as an array.

## How to use it in my project?

Just include the file `bootstrap.php` in your script.

## Warning!

It's a work in progress, any contribution is welcomed.
