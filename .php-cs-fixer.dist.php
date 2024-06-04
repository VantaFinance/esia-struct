<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony'                      => true,
        '@Symfony:risky'                => true,
        '@PSR12'                        => true,
        '@PSR12:risky'                  => true,
        'blank_line_before_statement'   => true,
        'final_public_method_for_abstract_class' => true,
        'final_class'                   => true,
        'declare_strict_types'          => true,
        'no_superfluous_phpdoc_tags'    => true,
        'single_line_throw'             => false,
        'concat_space'                  => ['spacing' => 'one'],
        'ordered_imports'               => true,
        'global_namespace_import'       => [
            'import_classes'   => true,
            'import_constants' => false,
            'import_functions' => false,
        ],
        'native_constant_invocation'    => false,
        'native_function_invocation'    => false,
        'modernize_types_casting'       => true,
        'is_null'                       => true,
        'array_syntax'                  => [
            'syntax' => 'short',
        ],
        'nullable_type_declaration_for_default_null_value' => true,
        'nullable_type_declaration'                        => ['syntax' => 'question_mark'],
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_summary'                => false,
        'logical_operators'             => true,
        'class_definition'              => false,
        'binary_operator_spaces'        => ['operators' => ['=>' => 'align_single_space_minimal', '=' => 'align_single_space_minimal']],
        '@PHP83Migration'               => true,
    ])
    ->setFinder($finder)
;
