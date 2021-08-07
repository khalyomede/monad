<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->notPath('tests/unit/Pest.php')
    ->in(__DIR__);

$config = new Config();

return $config->setRules([
    '@PhpCsFixer' => true,
    '@PhpCsFixer:risky' => true,
])
    ->setFinder($finder);
