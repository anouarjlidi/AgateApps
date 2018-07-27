<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'vendor',
    ])
    ->notPath('src/CorahnRin/PDF/FPDF.php')
    ->notPath('src/CorahnRin/PDF/PDF.php')
    ->notPath('src/CorahnRin/SheetsManagers/PdfManager.php')
    ->in(__DIR__.'/src/')
;

return PhpCsFixer\Config::create()
    ->setRules(
        [
            // Enabled rules
            '@DoctrineAnnotation'             => true,
            '@Symfony'                        => true,
            '@Symfony:risky'                  => true,
            '@PHP56Migration'                 => true,
            '@PHP70Migration'                 => true,
            '@PHP70Migration:risky'           => true,
            '@PHP71Migration'                 => true,
            'array_syntax'                    => [
                'syntax' => 'short',
            ],
            'strict_param'                    => true,
            'heredoc_to_nowdoc'               => true,
            'no_short_echo_tag'               => true,
            'no_useless_else'                 => true,
            'no_useless_return'               => true,
            'no_php4_constructor'             => true,
            'native_function_invocation'      => true,
            'fully_qualified_strict_types'    => true,
            'simplified_null_return'          => true,
            // Overrides default doctrine rule using ":" as character
            'doctrine_annotation_array_assignment' => [
                'operator' => '=',
            ],
            'multiline_whitespace_before_semicolons' => [
                'strategy' => 'new_line_for_chained_calls',
            ],
            // Disabled rules
            'increment_style' => false,
            'declare_strict_types' => false, // I guess you're not ready for that yet. But your kids're gonna love it!
        ]
    )
    ->setRiskyAllowed(true)
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setFinder($finder)
;
