<?php

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        '-align_equals',
        'align_equals',
        '-unalign_double_arrow',
        'align_double_arrow',
        'ereg_to_preg',
        'php4_constructor',
        'newline_after_open_tag',
        'short_array_syntax',
        'php_unit_construct',
        'php_unit_strict',
        'strict',
        'strict_param',
    ])
    ->finder(Symfony\CS\Finder\DefaultFinder::create()->in(__DIR__.'/src/'))
;
