<?php

declare(strict_types=1);

namespace Taptima\CS;

use PhpCsFixer\RuleSet;

final class RuleSetFactory
{
    /**
     * @const array
     */
    private const SET_DEFINITIONS = [
        '@Taptima' => [
            '@Symfony'            => true,
            '@DoctrineAnnotation' => true,
            '@PhpCsFixer'         => true,
            '@PHP71Migration'     => true,

            'blank_line_after_namespace'  => true,
            'single_import_per_statement' => true,
            'single_line_after_imports'   => true,
            'no_unused_imports'           => true,

            'ordered_imports'         => true,
            'global_namespace_import' => true,
            'ordered_class_elements'  => [
                'order' => [
                    'use_trait',
                    'constant',
                    'constant_public',
                    'constant_protected',
                    'constant_private',
                    'property_public_static',
                    'property_public',
                    'property_protected_static',
                    'property_protected',
                    'property_private_static',
                    'property_private',
                    'construct',
                    'destruct',
                    'magic',
                    'phpunit',
                    'method_public_static',
                    'method_public',
                    'method_protected_static',
                    'method_protected',
                    'method_private_static',
                    'method_private',
                ],
            ],

            'method_chaining_indentation' => false,

            'self_static_accessor' => true,

            'ternary_to_null_coalescing' => true,
            'binary_operator_spaces'     => [
                'default'   => 'single_space',
                'operators' => [
                    '='   => 'align_single_space_minimal',
                    '+='  => 'align_single_space_minimal',
                    '-='  => 'align_single_space_minimal',
                    '/='  => 'align_single_space_minimal',
                    '*='  => 'align_single_space_minimal',
                    '%='  => 'align_single_space_minimal',
                    '**=' => 'align_single_space_minimal',
                    '=>'  => 'align_single_space_minimal',
                ],
            ],
            'yoda_style' => [
                'equal'            => false,
                'identical'        => false,
                'less_and_greater' => null,
            ],
            'concat_space' => [
                'spacing' => 'one',
            ],
            'array_syntax' => [
                'syntax' => 'short',
            ],
            'braces'            => true,
            'elseif'            => true,
            'trim_array_spaces' => true,

            'function_declaration'          => true,
            'no_spaces_after_function_name' => true,
            'no_spaces_inside_parenthesis'  => true,

            'cast_spaces'                 => true,
            'encoding'                    => true,
            'full_opening_tag'            => true,
            'linebreak_after_opening_tag' => true,
            'no_closing_tag'              => true,
            'indentation_type'            => true,
            'line_ending'                 => true,
            'single_blank_line_at_eof'    => false,
            'no_trailing_whitespace'      => true,
            'lowercase_keywords'          => true,
            'no_whitespace_in_blank_line' => true,
            'blank_line_before_statement' => true,
            'echo_tag_syntax'             => true,

            'doctrine_annotation_braces'           => false,
            'doctrine_annotation_array_assignment' => [
                'operator' => '=',
            ],

            'align_multiline_comment' => [
                'comment_type' => 'all_multiline',
            ],

            'no_superfluous_phpdoc_tags'          => false,
            'phpdoc_order'                        => true,
            'phpdoc_separation'                   => true,
            'phpdoc_var_without_name'             => false,
            'phpdoc_var_annotation_correct_order' => true,
            'phpdoc_types_order'                  => [
                'sort_algorithm'  => 'none',
                'null_adjustment' => 'always_last',
            ],

            'nullable_type_declaration_for_default_null_value' => true,

            'phpdoc_add_missing_param_annotation' => [
                'only_untyped' => false,
            ],
        ],
    ];

    /**
     * @const array
     */
    private const RISKY_DEFINITION = [
        'phpdoc_to_param_type' => true,
        'void_return'          => true,
    ];

    /**
     * @var array[]
     */
    private $rules;

    /**
     * RuleSetFactory constructor.
     *
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        if (array_key_exists('@Taptima', $rules)) {
            unset($rules['@Taptima']);
            $rules = array_merge(self::SET_DEFINITIONS['@Taptima'], $rules);
        }

        $this->rules = $rules;
    }

    /**
     * @param array $rules
     *
     * @return RuleSetFactory
     */
    public static function create(array $rules = [])
    {
        return new self($rules);
    }

    /**
     * @return array
     */
    public function getRules()
    {
        $rules = $this->rules;

        ksort($rules);

        return $rules;
    }

    /**
     * @return RuleSetFactory
     */
    public function psr0()
    {
        return self::create(array_merge(
            $this->rules,
            ['@psr0' => true]
        ));
    }

    /**
     * @return RuleSetFactory
     */
    public function psr1()
    {
        return self::create(array_merge(
            $this->rules,
            ['@psr1' => true]
        ));
    }

    /**
     * @return RuleSetFactory
     */
    public function psr2()
    {
        return self::create(array_merge(
            $this->rules,
            ['@psr2' => true]
        ));
    }

    /**
     * @return RuleSetFactory
     */
    public function psr4()
    {
        return self::create(array_merge(
            $this->rules,
            ['@psr4' => true]
        ));
    }

    /**
     * @param bool $risky
     *
     * @return RuleSetFactory
     */
    public function symfony($risky = false)
    {
        $rules = ['@Symfony' => true];

        if ($risky) {
            $rules['@Symfony:risky'] = true;
        }

        return self::create(array_merge(
            $this->rules,
            $rules
        ));
    }

    /**
     * @param bool $risky
     *
     * @return RuleSetFactory
     */
    public function phpCsFixer($risky = false)
    {
        $rules = ['@PhpCsFixer' => true];

        if ($risky) {
            $rules['@PhpCsFixer:risky'] = true;
        }

        return self::create(array_merge(
            $this->rules,
            $rules
        ));
    }

    /**
     * @return RuleSetFactory
     */
    public function doctrineAnnotation()
    {
        return self::create(array_merge(
            $this->rules,
            ['@DoctrineAnnotation' => true]
        ));
    }

    /**
     * @param float|string $version
     * @param bool         $risky
     *
     * @return RuleSetFactory
     */
    public function php($version, $risky = false)
    {
        $config = $this->migration('php', $version, $risky)->getRules();

        switch (true) {
            case $version >= 7.1:
                $config = array_merge(['list_syntax' => ['syntax' => 'short']], $config);
            // no break
            case $version >= 5.4:
                $config = array_merge(['array_syntax' => ['syntax' => 'short']], $config);
        }

        $config = array_merge(['list_syntax' => ['syntax' => 'long']], $config);
        $config = array_merge(['array_syntax' => ['syntax' => 'long']], $config);

        return self::create(array_merge(
            $this->rules,
            $config
        ));
    }

    /**
     * @param float $version
     * @param bool  $risky
     *
     * @return RuleSetFactory
     */
    public function phpUnit($version, $risky = false)
    {
        return $this->migration('phpunit', $version, $risky);
    }

    /**
     * @param bool $risky
     *
     * @return RuleSetFactory
     */
    public function taptima($risky = false)
    {
        $rules = [];

        foreach (new Fixers() as $fixer) {
            if ($fixer->isDeprecated()) {
                continue;
            }

            $rules[$fixer->getName()] = true;
        }

        ksort($rules);

        $this->rules = array_merge(
            $this->rules,
            $rules
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function taptimaRisky()
    {
        $this->rules = array_merge(
            $this->rules,
            self::RISKY_DEFINITION
        );

        return $this;
    }

    /**
     * @param string $name
     *
     * @return RuleSetFactory
     */
    public function enable($name, array $config = null)
    {
        return self::create(array_merge(
            $this->rules,
            [$name => \is_array($config) ? $config : true]
        ));
    }

    /**
     * @param string $name
     *
     * @return RuleSetFactory
     */
    public function disable($name)
    {
        return self::create(array_merge(
            $this->rules,
            [$name => false]
        ));
    }

    /**
     * @param string $package
     * @param float  $version
     * @param bool   $risky
     *
     * @return RuleSetFactory
     */
    private function migration($package, $version, $risky)
    {
        $rules = (new RuleSet())->getSetDefinitionNames();
        $rules = array_combine($rules, $rules);

        $rules = array_map(function ($name) {
            $matches = [];

            preg_match('/^@([A-Za-z]+)(\d+)Migration(:risky|)$/', $name, $matches);

            return $matches;
        }, $rules);

        $rules = array_filter($rules);

        $rules = array_filter($rules, function ($versionAndRisky) use ($package) {
            [$rule, $rulePackage, $ruleVersion, $ruleRisky] = $versionAndRisky;

            return strtoupper($package) === strtoupper($rulePackage);
        });

        $rules = array_filter($rules, function ($versionAndRisky) use ($version) {
            [$rule, $rulePackage, $ruleVersion, $ruleRisky] = $versionAndRisky;

            return ((float) $ruleVersion / 10) <= $version;
        });

        $rules = array_filter($rules, function ($versionAndRisky) use ($risky) {
            [$rule, $rulePackage, $ruleVersion, $ruleRisky] = $versionAndRisky;

            if ($risky) {
                return true;
            }

            return empty($ruleRisky);
        });

        return self::create(array_merge(
            $this->rules,
            array_map(function () {
                return true;
            }, $rules)
        ));
    }
}
