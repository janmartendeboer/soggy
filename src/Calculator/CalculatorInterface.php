<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Calculator;

use Janmartendeboer\Soggy\Recipe\Recipe;

interface CalculatorInterface
{
    public function calculateScore(Recipe $recipe): int;
}
