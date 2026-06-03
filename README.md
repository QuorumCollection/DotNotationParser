# Dot Notation Parser

[![Latest Stable Version](https://poser.pugx.org/quorum/dot-notation/version)](https://packagist.org/packages/quorum/dot-notation)
[![Total Downloads](https://poser.pugx.org/quorum/dot-notation/downloads)](https://packagist.org/packages/quorum/dot-notation)
[![License](https://poser.pugx.org/quorum/dot-notation/license)](https://packagist.org/packages/quorum/dot-notation)
[![ci.yml](https://github.com/QuorumCollection/DotNotationParser/actions/workflows/ci.yml/badge.svg)](https://github.com/QuorumCollection/DotNotationParser/actions/workflows/ci.yml)


DotNotationParser is a simple parser that will parse `foo.bar.baz` into `[ 'foo', 'bar', 'baz' ]` and `foo."bar.baz"` into `[ 'foo', 'bar.baz' ]`.



## Requirements

- **php**: >=7.4

## Installing

Install the latest version with:

```bash
composer require 'quorum/dot-notation'
```

## Example

```php
<?php

use Quorum\DotNotation\DotNotationParser;

require __DIR__ . '/../vendor/autoload.php';

$parser = new DotNotationParser;

$tests = [
	'foo',
	'foo.bar',
	'spaces are allowed'                  => 'foo bar.baz',
	'dots are accepted in quotes'         => '"foo.bar".baz',
	'quotes are escaped with backslashes' => '"foo\"bar\"".baz',
];

foreach( $tests as $descr => $test ) {
	echo sprintf("Parsing '%s'%s\n",
		$test,
		is_numeric($descr) ? '' : ' - ' . $descr);

	$parts = $parser->parse($test);

	echo sprintf("[ %s ]\n", implode(", ", array_map(
		function ( $a ) { return var_export($a, true); },
		$parts)));
	echo "\n";
}

```

```
Parsing 'foo'
[ 'foo' ]

Parsing 'foo.bar'
[ 'foo', 'bar' ]

Parsing 'foo bar.baz' - spaces are allowed
[ 'foo bar', 'baz' ]

Parsing '"foo.bar".baz' - dots are accepted in quotes
[ 'foo.bar', 'baz' ]

Parsing '"foo\"bar\"".baz' - quotes are escaped with backslashes
[ 'foo"bar"', 'baz' ]

```

## Documentation

### Class: Quorum\DotNotation\DotNotationParser

Class DotPathParser

Parse strings like foo."bar.baz".quux into [ 'foo', 'bar.baz', 'quux' ]

#### Method: DotNotationParser->parse

```php
function parse(string $path) : array
```

Parse a given dot notation path into it's parts  
  
The path is expected to be a string of dot separated keys, where keys can be  
quoted with double quotes. Backslashes are used to escape double quotes inside  
quoted keys.  

##### Examples

- `'foo.bar.baz'` => `[ 'foo', 'bar', 'baz' ]`  
- `'foo."bar.baz"'` => `[ 'foo', 'bar.baz' ]`  
- `'foo."bar.baz".quux'` => `[ 'foo', 'bar.baz', 'quux' ]`  
- `'foo."bar\"baz".quux'` => `[ 'foo', 'bar"baz', 'quux' ]`

**Throws**: `\Quorum\DotNotation\Exceptions\ParseException`

##### Returns:

- ***string[]***