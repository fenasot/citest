<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');

$config = new PhpCsFixer\Config();
$config
    ->setRules([
        '@PSR12' => true,
        'php_unit_test_class_requires_covers' => false,
        'array_syntax' => ['syntax' => 'short'],
        // 允许 PHP 内嵌的 HTML
        'phpdoc_to_comment' => false,
    ])
    ->setFinder($finder);

return $config;