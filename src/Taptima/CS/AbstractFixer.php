<?php

declare(strict_types=1);

namespace Taptima\CS;

use PhpCsFixer\AbstractFixer as PhpCsFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

abstract class AbstractFixer extends PhpCsFixer
{
    /**
     * {@inheritdoc}
     */
    public function isCandidate(Tokens $tokens)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return sprintf('Taptima/%s', parent::getName());
    }

    /**
     * @return array[]
     */
    public function getSampleConfigurations()
    {
        return [
            [],
        ];
    }

    /**
     * @return string
     */
    abstract public function getSampleCode();

    /**
     * @return string
     */
    abstract public function getDocumentation();

    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new FixerDefinition(
            $this->getDocumentation(),
            array_map(
                function (array $configutation = null) {
                    return new CodeSample($this->getSampleCode(), $configutation);
                },
                $this->getSampleConfigurations()
            )
        );
    }

    /**
     * @return bool
     */
    public function isDeprecated()
    {
        return false;
    }

    /**
     * @return string|null
     */
    public function getDeprecationReplacement()
    {
    }

    /**
     * @return TokensAnalyzer
     */
    protected function analyze(Tokens $tokens)
    {
        return new TokensAnalyzer($tokens);
    }

    /**
     * @param string|string[] $fqcn
     *
     * @return bool
     */
    protected function hasUseStatements(Tokens $tokens, $fqcn)
    {
        return $this->getUseStatements($tokens, $fqcn) !== null;
    }

    /**
     * @param string|string[] $fqcn
     *
     * @return array|null
     */
    protected function getUseStatements(Tokens $tokens, $fqcn)
    {
        if (\is_array($fqcn) === false) {
            $fqcn = explode('\\', $fqcn);
        }
        $sequence = [[T_USE]];
        foreach ($fqcn as $component) {
            $sequence = array_merge(
                $sequence,
                [[T_STRING, $component], [T_NS_SEPARATOR]]
            );
        }
        $sequence[\count($sequence) - 1] = ';';

        return $tokens->findSequence($sequence);
    }

    /**
     * @param string|string[] $fqcn
     *
     * @return bool
     */
    protected function extendsClass(Tokens $tokens, $fqcn)
    {
        if (\is_array($fqcn) === false) {
            $fqcn = explode('\\', $fqcn);
        }

        if ($this->hasUseStatements($tokens, $fqcn) === false) {
            return false;
        }

        return $tokens->findSequence([
            [T_CLASS],
            [T_STRING],
            [T_EXTENDS],
            [T_STRING, array_pop($fqcn)],
        ]) !== null;
    }

    /**
     * @param string|string[] $fqcn
     *
     * @return bool
     */
    protected function implementsInterface(Tokens $tokens, $fqcn)
    {
        if (\is_array($fqcn) === false) {
            $fqcn = explode('\\', $fqcn);
        }

        if ($this->hasUseStatements($tokens, $fqcn) === false) {
            return false;
        }

        return $tokens->findSequence([
            [T_CLASS],
            [T_STRING],
            [T_IMPLEMENTS],
            [T_STRING, array_pop($fqcn)],
        ]) !== null;
    }

    /**
     * @param Tokens $tokens
     *
     * @return Token[]
     */
    protected function getComments(Tokens $tokens)
    {
        $comments = [];

        foreach ($tokens as $index => $token) {
            if ($token->isComment()) {
                $comments[$index] = $token;
            }
        }

        return $comments;
    }
}