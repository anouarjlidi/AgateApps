<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'vendor',
    ])
    ->notPath('src/CorahnRin/CorahnRinBundle/PDF/FPDF.php')
    ->notPath('src/CorahnRin/CorahnRinBundle/PDF/PDF.php')
    ->notPath('src/CorahnRin/CorahnRinBundle/SheetsManagers/PdfManager.php')
    ->in(__DIR__.'/src/')
;

return PhpCsFixer\Config::create()
    ->setRules(
        [
            // Enabled rules
            '@Symfony'                        => true,
            '@Symfony:risky'                  => true,
            '@PHP70Migration'                 => true,
            '@PHP71Migration'                 => true,
            '@PHP56Migration'                 => true,
            'array_syntax'                    => [
                'syntax' => 'short',
            ],
            'binary_operator_spaces'          => [
                'align_double_arrow' => true,
                'align_equals'       => true,
            ],
            'strict_param'                    => true,
            'heredoc_to_nowdoc'               => true,
            'no_short_echo_tag'               => true,
            'no_useless_else'                 => true,
            'no_useless_return'               => true,
            'no_php4_constructor'             => true,
            'doctrine_annotation_indentation' => true,
            'doctrine_annotation_braces'      => [
                'syntax' => 'with_braces',
            ],
            // TODO: Add when new php-cs-fixer releases
//            'doctrine_annotation_array_assignment' => [
//                'operator' => '=',
//            ],
            // Disabled rules
            'pre_increment' => false,
            'doctrine_annotation_spaces'                => false,
            'no_multiline_whitespace_before_semicolons' => false,
        ]
    )
    ->setRiskyAllowed(true)
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setFinder($finder)
;
