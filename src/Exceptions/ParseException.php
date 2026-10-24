<?php

declare(strict_types=1);

namespace Quorum\DotNotation\Exceptions;

class ParseException extends \InvalidArgumentException {

	public const CODE_UNEXPECTED_CHARACTER = 22;
	public const CODE_UNEXPECTED_EOF       = 484;

	public function __construct(
		string $message,
		private readonly int $charIndex,
		int $code,
		?\Throwable $previous = null
	) {
		parent::__construct($message, $code, $previous);
	}

	public function getCharIndex() : int {
		return $this->charIndex;
	}

}
