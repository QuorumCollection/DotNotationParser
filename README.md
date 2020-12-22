# Dot Notation Parser

[![Latest Stable Version](https://poser.pugx.org/quorum/dot-notation/version)](https://packagist.org/packages/quorum/dot-notation)
[![Total Downloads](https://poser.pugx.org/quorum/dot-notation/downloads)](https://packagist.org/packages/quorum/dot-notation)
[![License](https://poser.pugx.org/quorum/dot-notation/license)](https://packagist.org/packages/quorum/dot-notation)
[![Build Status](https://github.com/CorpusPHP/Di/workflows/CI/badge.svg?)](https://github.com/CorpusPHP/Di/actions?query=workflow%3ACI)


DotNotationParser is a simple parser that will parse `foo.bar.baz` into `[ 'foo', 'bar', 'baz' ]` and `foo."bar.baz"` into `[ 'foo', 'bar.baz' ]`.



## Requirements

- **php**: >=7.1

## Installing

Install the latest version with:

```bash
composer require 'quorum/dot-notation'
```

## Documentation

### Class: \Quorum\DotNotation\DotNotationParser

Class DotPathParser

Parse strings like foo."bar.baz".quux into [ 'foo', 'bar.baz', 'quux' ]

#### Method: DotNotationParser->parse

```php
function parse(string $path) : array
```

Parse a given dot notation path into it's parts

##### Returns:

- ***string[]***