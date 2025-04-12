<?php

namespace Quorum\DotNotation\Exceptions;

class ParseException extends \InvalidArgumentException {

	public const CODE_UNEXPECTED_CHARACTER = 22;
	public const CODE_UNEXPECTED_EOF       = 484;

	/** @var int The index of the character that caused the exception */
	private $charIndex;

	public function __construct( string $message, int $charIndex, int $code, ?\Throwable $previous = null ) {
		parent::__construct($message, $code, $previous);

		$this->charIndex = $charIndex;
	}

	public function getCharIndex() : int {
		return $this->charIndex;
	}

}
