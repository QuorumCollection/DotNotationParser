# Dot Notation Parser

[![Latest Stable Version](https://poser.pugx.org/quorum/dot-notation/version)](https://packagist.org/packages/quorum/dot-notation)
[![Total Downloads](https://poser.pugx.org/quorum/dot-notation/downloads)](https://packagist.org/packages/quorum/dot-notation)
[![License](https://poser.pugx.org/quorum/dot-notation/license)](https://packagist.org/packages/quorum/dot-notation)
[![Build Status](https://travis-ci.org/QuorumCollection/DotNotationParser.svg?branch=master)](https://travis-ci.org/QuorumCollection/DotNotationParser)


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

#### Method: DotNotationParser->parse

```php
function parse(string $path) : array
```

##### Parameters:

- ***string*** `$path`

##### Returns:

- ***string[]***