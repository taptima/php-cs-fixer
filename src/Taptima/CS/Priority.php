<?php

declare(strict_types=1);

namespace Taptima\CS;

final class Priority
{
    private function __construct()
    {
    }

    /**
     * @param array<int,mixed> $classes
     *
     * @return int
     */
    public static function before(...$classes): int
    {
        $priorities = array_map(
            static function ($class) {
                return (new $class())->getPriority();
            },
            $classes
        );

        return max($priorities) + 1;
    }

    /**
     * @param array<int,mixed> $classes
     *
     * @return int
     */
    public static function after(...$classes): int
    {
        $priorities = array_map(
            static function ($class) {
                return (new $class())->getPriority();
            },
            $classes
        );

        return min($priorities) - 1;
    }
}
