<?php

namespace Quorum\DotNotation\Exceptions;

class ParseException extends \InvalidArgumentException {

	public const CODE_UNEXPECTED_CHARACTER = 22;
	public const CODE_UNEXPECTED_EOF       = 484;

	private $charIndex;

	public function __construct( $message, int $charIndex, $code, \Throwable $previous = null ) {
		parent::__construct($message, $code, $previous);

		$this->charIndex = $charIndex;
	}

	public function getCharIndex() : int {
		return $this->charIndex;
	}

}
