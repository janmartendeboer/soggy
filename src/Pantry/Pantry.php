<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Pantry;

use Generator;
use Janmartendeboer\Soggy\Recipe\Ingredient;
use Janmartendeboer\Soggy\Recipe\IngredientMeasurement;
use Measurements\Measurement;

final class Pantry
{
    /** @var array<string,IngredientMeasurement> */
    private array $ingredients;

    public function __construct(IngredientMeasurement ...$ingredients)
    {
        $this->ingredients = array_reduce(
            $ingredients,
            static fn (array $carry, IngredientMeasurement $ingredient) => array_replace(
                $carry,
                [$ingredient->ingredient->name => $ingredient]
            ),
            []
        );
    }

    /**
     * @return Generator&Ingredient[]
     */
    public function getAvailableIngredients(): Generator
    {
        foreach ($this->ingredients as $ingredient) {
            if ($ingredient->measurement->value() <= 0) {
                continue;
            }

            yield $ingredient->ingredient;
        }
    }

    public function getIngredient(
        Ingredient $ingredient,
        Measurement $measurement
    ): IngredientMeasurement {
        $result = $this->ingredients[$ingredient->name] ?? null;

        if (!$result instanceof IngredientMeasurement) {
            throw new IngredientNotFoundException(
                sprintf(
                    'Could not find ingredient "%s" in pantry.',
                    $ingredient->name
                )
            );
        }

        if (!$result->measurement->isGreaterThanOrEqualTo($measurement)) {
            throw new OutOfStockException(
                sprintf(
                    'Requested "%s" of "%s", yet only has "%s"',
                    $measurement,
                    $ingredient->name,
                    $result->measurement
                )
            );
        }

        return new IngredientMeasurement($result->ingredient, $measurement);
    }
}
