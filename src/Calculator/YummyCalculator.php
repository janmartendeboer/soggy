<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Calculator;

use Janmartendeboer\Soggy\Recipe\Recipe;
use Measurements\Dimension;

class YummyCalculator implements CalculatorInterface
{
    private const PROPERTIES = ['capacity', 'durability', 'flavor', 'texture'];
    private const MINIMAL_PROPERTY_SCORE = 0;

    public function __construct(private Dimension $dimension) {}

    public function calculateScore(Recipe $recipe): int
    {
        return array_product(
            array_map(
                fn (string $property) => self::calculatePropertyScore(
                    $property,
                    $recipe,
                    $this->dimension
                ),
                self::PROPERTIES
            )
        );
    }

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

        return max(self::MINIMAL_PROPERTY_SCORE, $score);
    }
}
