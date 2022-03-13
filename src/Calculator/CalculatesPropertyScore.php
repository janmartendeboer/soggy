<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Calculator;

use Janmartendeboer\Soggy\Recipe\Recipe;
use Measurements\Dimension;

trait CalculatesPropertyScore
{
    private static function calculatePropertyScore(
        string $property,
        Recipe $recipe,
        Dimension $dimension
    ): int {
        $score = 0;

        foreach ($recipe->getIngredientMeasurements() as $ingredientMeasurement) {
            $units = (int)$ingredientMeasurement
                ->measurement
                ->convertTo($dimension)
                ->value();

            $score += (
                $units * $ingredientMeasurement->ingredient->{$property}
            );
        }

        return $score;
    }
}
