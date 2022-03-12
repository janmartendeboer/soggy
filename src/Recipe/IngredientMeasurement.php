<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Recipe;

use Measurements\Measurement;

final class IngredientMeasurement
{
    public function __construct(
        public readonly Ingredient $ingredient,
        public readonly Measurement $measurement
    ) {}
}
