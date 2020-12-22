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
	 * @return string[]
	 */
	public function parse( string $path ) : array {
		$out   = [];
		$chars = preg_split('/(?<!^)(?!$)/u', $path, -1, PREG_SPLIT_NO_EMPTY) ?: [];

		for(;;) {
			$token = current($chars);
			if( $token === false ) {
				break;
			}

			switch( $token ) {
				case '.':
					throw new ParseException(
						sprintf('failed to parse path, expected string, got "%s" at %d', $token, key($chars)),
						key($chars),
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
	 * @param string[] $chars array of unicode characters by reference
	 */
	private function scanString( array &$chars ) : string {
		$buff = '';
		for(;;) {
			$token = current($chars);
			if( $token === false || $token === '.' ) {
				next($chars);

				break;
			}

			$buff .= $token;
			next($chars);
		}

		return $buff;
	}

	/**
	 * @param string[] $chars array of unicode characters by reference
	 */
	private function scanQuotedString( array &$chars ) : string {
		$buff = '';

		next($chars);
		for(;;) {
			$token = current($chars);
			if( $token === false ) {
				throw new ParseException(
					'failed to parse path, expected ", got EOF',
					key($chars) ?: count($chars),
					ParseException::CODE_UNEXPECTED_EOF
				);
			}

			if( $token === '"' ) {
				$next = next($chars);
				if( $next === false || $next === '.' ) {
					next($chars);
					break;
				}

				throw new ParseException(
					sprintf('failed to parse path, expected . or EOF, got "%s" at %d', $next, key($chars)),
					key($chars),
					ParseException::CODE_UNEXPECTED_CHARACTER
				);
			}

			$buff .= $token;
			next($chars);
		}

		return $buff;
	}

}
