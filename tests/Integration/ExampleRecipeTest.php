<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Tests\Integration;

use Janmartendeboer\Soggy\Calculator\CaloriesCalculator;
use Janmartendeboer\Soggy\Calculator\YummyCalculator;
use Janmartendeboer\Soggy\Recipe\Ingredient;
use Janmartendeboer\Soggy\Recipe\IngredientMeasurement;
use Janmartendeboer\Soggy\Recipe\Recipe;
use Measurements\Quantities\Volume;
use Measurements\Units\UnitVolume;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class ExampleRecipeTest extends TestCase
{
    use AssertsVolume;

    public function testWinningRecipe(): void
    {
        $dimension = UnitVolume::teaspoons();

        $recipe = new Recipe('Butterscotch Cinnamon Heaven');
        $recipe->setIngredientMeasurement(
            new IngredientMeasurement(
                new Ingredient(
                    name:       'Butterscotch',
                    capacity:   -1,
                    durability: -2,
                    flavor:     6,
                    texture:    3,
                    calories:   8
                ),
                new Volume(44, $dimension)
            )
        );
        $recipe->setIngredientMeasurement(
            new IngredientMeasurement(
                new Ingredient(
                    name:       'Cinnamon',
                    capacity:   2,
                    durability: 3,
                    flavor:     -2,
                    texture:    -1,
                    calories:   3
                ),
                new Volume(56, $dimension)
            )
        );

        self::assertRecipeHolds100Teaspoons($recipe);

        $calculator = new YummyCalculator($dimension);

        self::assertEquals(
            62842880,
            $calculator->calculateScore($recipe),
            'Recipe must have a score of exactly 62842880 points.'
        );
    }

    public function testMealReplacementRecipe(): void
    {
        $dimension = UnitVolume::teaspoons();

        $recipe = new Recipe('Butterscotch Cinnamon Heaven');
        $recipe->setIngredientMeasurement(
            new IngredientMeasurement(
                new Ingredient(
                    name:       'Butterscotch',
                    capacity:   -1,
                    durability: -2,
                    flavor:     6,
                    texture:    3,
                    calories:   8
                ),
                new Volume(40, $dimension)
            )
        );
        $recipe->setIngredientMeasurement(
            new IngredientMeasurement(
                new Ingredient(
                    name:       'Cinnamon',
                    capacity:   2,
                    durability: 3,
                    flavor:     -2,
                    texture:    -1,
                    calories:   3
                ),
                new Volume(60, $dimension)
            )
        );

        self::assertRecipeHolds100Teaspoons($recipe);

        $caloriesCalculator = new CaloriesCalculator($dimension);

        self::assertEquals(
            500,
            $caloriesCalculator->calculateScore($recipe),
            'Recipe must be exactly 500 calories.'
        );

        $calculator = new YummyCalculator($dimension);

        self::assertEquals(
            57600000,
            $calculator->calculateScore($recipe),
            'Recipe must have a score of exactly 62842880 points.'
        );
    }
}
