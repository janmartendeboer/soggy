<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Calculator;

use Janmartendeboer\Soggy\Recipe\Recipe;
use Measurements\Dimension;

class CaloriesCalculator implements CalculatorInterface
{
    use CalculatesPropertyScore;

    public function __construct(private Dimension $dimension) {}

    public function calculateScore(Recipe $recipe): int
    {
        return self::calculatePropertyScore(
            'calories',
            $recipe,
            $this->dimension
        );
    }
}
