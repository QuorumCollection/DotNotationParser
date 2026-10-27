<?php

use Corpus\PhpCsFixer\Config;
use PhpCsFixer\Finder;

$config = Config::php8x2();

return $config
	->setRules(
		[
			...$config->getRules(),
			'@PHPUnit11x0Migration:risky' => true,
		],
	)
	->setFinder(
		Finder::create()
			->files()
			->in(__DIR__ . '/src')
			->in(__DIR__ . '/test')
			->in(__DIR__ . '/example')
			->name('*.php'),
	);
