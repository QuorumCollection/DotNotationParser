<?php

use Corpus\PhpCsFixer\Config;
use PhpCsFixer\Finder;

return Config::php8x2()
	->setFinder(
		Finder::create()
			->files()
			->in(__DIR__ . '/src')
			->in(__DIR__ . '/test')
			->in(__DIR__ . '/example')
			->name('*.php'),
	);
