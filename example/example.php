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
