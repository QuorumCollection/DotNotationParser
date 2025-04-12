<?php

namespace Quorum\DotNotation;

use Quorum\DotNotation\Exceptions\ParseException;

/**
 * Class DotPathParser
 *
 * Parse strings like foo."bar.baz".quux into [ 'foo', 'bar.baz', 'quux' ]
 */
class DotNotationParser {

	/**
	 * Parse a given dot notation path into it's parts
	 *
	 * The path is expected to be a string of dot separated keys, where keys can be
	 * quoted with double quotes. Backslashes are used to escape double quotes inside
	 * quoted keys.
	 *
	 * Examples:
	 *
	 * - `'foo.bar.baz'` => `[ 'foo', 'bar', 'baz' ]`
	 * - `'foo."bar.baz"'` => `[ 'foo', 'bar.baz' ]`
	 * - `'foo."bar.baz".quux'` => `[ 'foo', 'bar.baz', 'quux' ]`
	 * - `'foo."bar\"baz".quux'` => `[ 'foo', 'bar"baz', 'quux' ]`
	 *
	 * @throws ParseException
	 * @return string[]
	 */
	public function parse( string $path ) : array {
		$out   = [];
		$chars = $this->iterateGraphemes($path);

		while( $chars->valid() ) {
			$token = $chars->current();
			$key   = $chars->key();

			switch( $token ) {
				case '.':
					throw new ParseException(
						sprintf('failed to parse path, expected string, got "%s" at %d', $token, $key),
						$key,
						ParseException::CODE_UNEXPECTED_CHARACTER
					);
				case '"':
					$out[] = $this->scanQuotedString($chars);
					break;
				default:
					$out[] = $this->scanString($chars);
					break;
			}
		}

		return $out;
	}

	/**
	 * @param \Iterator<int,string> $chars Generator of Unicode characters
	 */
	private function scanString( \Iterator $chars ) : string {
		$buff = '';
		while( $chars->valid() ) {
			$token = $chars->current();

			if( $token === '.' ) {
				$chars->next();
				break;
			}

			$buff .= $token;
			$chars->next();
		}

		return $buff;
	}

	/**
	 * @param \Iterator<int,string> $chars array of Unicode characters by reference
	 */
	private function scanQuotedString( \Iterator $chars ) : string {
		$buff = '';

		$chars->next();
		$lastKey = $chars->key();
		for(;;) {
			$token = $chars->current();
			$key   = $chars->key();

			if( !$chars->valid() ) {
				throw new ParseException(
					'failed to parse path, expected ", got EOF',
					$key ?? ($lastKey + 1),
					ParseException::CODE_UNEXPECTED_EOF
				);
			}

			if( $token === '"' ) {
				$chars->next();
				$next    = $chars->current();
				$nextKey = $chars->key();

				if( !$chars->valid() || $next === '.' ) {
					$chars->next();
					break;
				}

				throw new ParseException(
					sprintf('failed to parse path, expected . or EOF, got "%s" at %d', $next, $key),
					$nextKey ?? $key,
					ParseException::CODE_UNEXPECTED_CHARACTER
				);
			}

			if( $token === '\\' ) {
				$chars->next();
				$token = $chars->current();
				$key   = $chars->key();

				if( !$chars->valid() ) {
					continue;
				}
			}

			$buff .= $token;

			$lastKey = $key;
			$chars->next();
		}

		return $buff;
	}

	/**
	 * Yields each grapheme (user‑visible “character”) from $s.
	 *
	 * @return \Generator<int,string>
	 */
	private function iterateGraphemes( string $s ) : \Generator {
		$off = 0;
		$len = strlen($s);

		while( $off < $len && preg_match('/\X/u', $s, $m, 0, $off) ) {
			$g = $m[0];              // one grapheme cluster, UTF‑8 safe

			yield $off => $g;

			$off += strlen($g);  // advance by its byte length
		}
	}

}
