<?php

namespace Quorum\DotNotation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Quorum\DotNotation\Exceptions\ParseException;

class DotNotationParserTest extends TestCase {

	/**
	 * @param list<string> $result
	 */
	#[DataProvider('parseProvider')]
	public function testParse( string $path, array $result ): void {
		$parser = new DotNotationParser;

		$this->assertSame(
			$result,
			$parser->parse($path),
		);
	}

	/**
	 * @return list<array{string, list<string>}>
	 */
	public static function parseProvider(): array {
		return [
			[ '', [] ],
			[ 'foo.bar.baz', [ 'foo', 'bar', 'baz' ] ],
			[ 'foo."bar.baz"', [ 'foo', 'bar.baz' ] ],
			[ 'foo.bar"baz".2', [ 'foo', 'bar"baz"', '2' ] ],
			[ 'foo.bar.baz.', [ 'foo', 'bar', 'baz' ] ],
			[ '日.本.語', [ '日', '本', '語' ] ],
			[ 'foo."bar\"baz".quux', [ 'foo', 'bar"baz', 'quux' ] ],
			[ 'foo."bar\\\baz".quux.', [ 'foo', 'bar\baz', 'quux' ] ],
		];
	}

	#[DataProvider('unexpectedCharacterProvider')]
	public function testUnexpectedCharacters( string $path, int $pos ): void {
		try {
			$parser = new DotNotationParser;
			$parser->parse($path);
		} catch( ParseException $ex ) {
			$this->assertSame($ex->getCharIndex(), $pos);

			return;
		}

		$this->fail(sprintf('"%s" failed to throw exception', $path));
	}

	/**
	 * @return list<array{string, int}>
	 */
	public static function unexpectedCharacterProvider(): array {
		return [
			[ 'foo."bar', 8 ],
			[ 'a.foo."bar"baz', 11 ],
			[ '.foo', 0 ],
			[ '.', 0 ],
			[ 'foo."👨‍👩‍👧‍👦"."broke', 38 ],
			[ 'a..', 2 ],
			[ 'a..b', 2 ],
			[ 'a."\\', 4 ],
		];
	}

}
