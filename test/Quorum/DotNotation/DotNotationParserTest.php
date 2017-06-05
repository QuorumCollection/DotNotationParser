<?php

namespace Quorum\DotNotation;

use PHPUnit\Framework\TestCase;
use Quorum\DotNotation\Exceptions\ParseException;

class DotNotationParserTest extends TestCase {

	/**
	 * @dataProvider parseProvider
	 * @param string   $path
	 * @param string[] $result
	 */
	public function testParse( string $path, array $result ) : void {
		$parser = new DotNotationParser;

		$this->assertSame(
			$result,
			$parser->parse($path)
		);
	}

	public function parseProvider() : \Generator {
		yield [ 'foo.bar.baz', [ 'foo', 'bar', 'baz' ] ];
		yield [ 'foo."bar.baz"', [ 'foo', 'bar.baz' ] ];
		yield [ 'foo.bar"baz".2', [ 'foo', 'bar"baz"', '2' ] ];
		yield [ 'foo.bar.baz.', [ 'foo', 'bar', 'baz' ] ];
		yield [ '日.本.語', [ '日', '本', '語' ] ];
	}

	/**
	 * @dataProvider unexpectedCharacterProvider
	 */
	public function testUnexpectedCharacters( string $path, int $pos ) : void {
		try {
			$parser = new DotNotationParser;
			$parser->parse($path);
		} catch( ParseException $ex ) {
			$this->assertSame($ex->getCharIndex(), $pos);

			return;
		}

		$this->fail(sprintf('"%s" failed to throw exception', $path));
	}

	public function unexpectedCharacterProvider() : \Generator {
		yield [ 'foo."bar', 8 ];
		yield [ 'a.foo."bar"baz', 11 ];
		yield [ '.foo', 0 ];
		yield [ '.', 0 ];
	}
}
