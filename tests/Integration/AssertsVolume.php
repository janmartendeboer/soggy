<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Tests\Integration;

use Janmartendeboer\Soggy\Recipe\Recipe;
use Measurements\Units\UnitVolume;

trait AssertsVolume
{
    private static function assertRecipeHolds100Teaspoons(
        Recipe $actual,
        string $message = null
    ): void {
        self::assertEquals(
            '100 tsp',
            (string)$actual->getVolume(UnitVolume::teaspoons()),
            $message ?? 'Recipe must be exactly 100 teaspoons in volume.'
        );
    }
}
