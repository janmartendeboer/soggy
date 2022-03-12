<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Recipe;

use Generator;
use Measurements\Dimension;
use Measurements\Measurement;
use Measurements\Quantities\Volume;
use Measurements\Units\UnitVolume;

final class Recipe
{
    /** @var array<string,IngredientMeasurement> */
    private array $ingredients = [];

    public function __construct(public readonly string $name) {}

    public function setIngredientMeasurement(IngredientMeasurement $ingredient): void
    {
        $this->ingredients[$ingredient->ingredient->name] = $ingredient;
    }

    /**
     * @yield IngredientMeasurement
     */
    public function getIngredientMeasurements(): Generator
    {
        yield from $this->ingredients;
    }

    public function getVolume(Dimension $dimension = null): Measurement
    {
        $dimension ??= UnitVolume::teaspoons();

        return array_reduce(
            $this->ingredients,
            fn (Measurement $carry, IngredientMeasurement $ingredientMeasurement) => (
                $carry
                    ->add($ingredientMeasurement->measurement)
                    ->convertTo($dimension)
            ),
            new Volume(0, $dimension)
        );
    }
}
