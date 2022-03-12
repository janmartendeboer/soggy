<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Tests\Integration;

use Janmartendeboer\Soggy\Recipe\Recipe;

trait AssertsRecipe
{
    private static function assertRecipeMatchesRecipe(
        Recipe $expected,
        Recipe $actual,
        string $message = null
    ): void {
        self::assertJsonStringEqualsJsonString(
            json_encode($expected),
            json_encode($actual),
            $message ?? 'Recipe ingredients must match.'
        );
    }
}
