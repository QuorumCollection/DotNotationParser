# Dot Notation Parser

[![Latest Stable Version](https://poser.pugx.org/quorum/dot-notation/version)](https://packagist.org/packages/quorum/dot-notation)
[![Total Downloads](https://poser.pugx.org/quorum/dot-notation/downloads)](https://packagist.org/packages/quorum/dot-notation)
[![License](https://poser.pugx.org/quorum/dot-notation/license)](https://packagist.org/packages/quorum/dot-notation)
[![ci.yml](https://github.com/QuorumCollection/DotNotationParser/actions/workflows/ci.yml/badge.svg)](https://github.com/QuorumCollection/DotNotationParser/actions/workflows/ci.yml)


DotNotationParser is a simple parser that will parse `foo.bar.baz` into `[ 'foo', 'bar', 'baz' ]` and `foo."bar.baz"` into `[ 'foo', 'bar.baz' ]`.



## Requirements

- **php**: >=7.1

## Installing

Install the latest version with:

```bash
composer require 'quorum/dot-notation'
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