<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Finder;

use Generator;

trait CreatesDispersionMatrix
{
    public static function createDispersionMatrix(
        int $total,
        ...$axes
    ): Generator {
        $numAxes = count($axes);

        if ($numAxes === 0) {
            return;
        }

        if ($numAxes === 1) {
            yield [[current($axes), $total]];
            return;
        }

        $mainAxis = array_shift($axes);

        for ($value = $total; $value >=0; $value--) {
            $childAxes = self::createDispersionMatrix(
                $total - $value,
                ...$axes
            );

            foreach ($childAxes as $options) {
                yield [[$mainAxis, $value], ...$options];
            }
        }
    }
}
