<?php

declare(strict_types=1);

namespace Taptima\CS;

use IteratorAggregate;
use PhpCsFixer\Fixer\FixerInterface;
use ReflectionClass;
use ReturnTypeWillChange;
use Symfony\Component\Finder\Finder;
use Throwable;

final class Fixers implements IteratorAggregate
{
    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $dir    = __DIR__ . '/Fixer';
        $finder = new Finder();
        $finder
            ->in($dir)
            ->name('*.php')
        ;

        $files = array_map(
            static function ($file) {
                return $file->getPathname();
            },
            iterator_to_array($finder)
        );

        sort($files);

        foreach ($files as $file) {
            $class = str_replace('/', '\\', mb_substr($file, mb_strlen($dir) - 16, -4));

            if (class_exists($class) === false) {
                continue;
            }

            try {
                $rfl = new ReflectionClass($class);
            } catch (Throwable $e) {
                continue;
            }

            if ($rfl->implementsInterface(FixerInterface::class) === false) {
                continue;
            }

            if ($rfl->isAbstract()) {
                continue;
            }

            yield new $class();
        }
    }
}
