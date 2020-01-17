<?php

declare(strict_types=1);

namespace tests;

use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use Taptima\CS\Fixer\DoctrineMigrationsFixer;
use Taptima\CS\Fixer\OrderedSettersAndGettersFixer;
use Webmozart\Assert\Assert;

final class Orchestra
{
    /**
     * @var FixerInterface
     */
    private $fixer;

    private function __construct(FixerInterface $fixer)
    {
        $this->fixer = $fixer;
    }

    public static function run(): void
    {
        self::assert(new OrderedSettersAndGettersFixer())
            ->before(new OrderedClassElementsFixer())
        ;

        self::assert(new DoctrineMigrationsFixer())
            ->before(new ClassAttributesSeparationFixer())
            ->before(new NoEmptyPhpdocFixer())
            ->before(new NoExtraBlankLinesFixer())
            ->before(new SingleLineAfterImportsFixer())
            ->before(new NoWhitespaceInBlankLineFixer())
        ;
    }

    /**
     * @return Orchestra
     */
    public static function assert(FixerInterface $fixer)
    {
        return new self($fixer);
    }

    /**
     * @return Orchestra
     */
    public function before(FixerInterface $other)
    {
        echo sprintf("Run %s before %s\n", $this->fixer->getName(), $other->getName());

        Assert::greaterThan(
            $this->fixer->getPriority(),
            $other->getPriority()
        );

        return $this;
    }

    /**
     * @return Orchestra
     */
    public function after(FixerInterface $other)
    {
        echo sprintf("Run %s after %s\n", $this->fixer->getName(), $other->getName());

        Assert::lessThan(
            $this->fixer->getPriority(),
            $other->getPriority()
        );

        return $this;
    }
}