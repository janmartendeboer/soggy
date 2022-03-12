<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Tests\Integration;

use Janmartendeboer\Soggy\Recipe\Ingredient;
use Janmartendeboer\Soggy\Recipe\IngredientMeasurement;
use Janmartendeboer\Soggy\Recipe\Recipe;
use Measurements\Quantities\Volume;
use Measurements\Units\UnitVolume;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class RecipeVariationsTest extends TestCase
{
    use AssertsVolume;

    public function testWinningRecipe(): void
    {
        $dimension = UnitVolume::teaspoons();

        $recipe = new Recipe('Butterscotch Cinnamon Heaven');
        $recipe->setIngredientMeasurement(
            new IngredientMeasurement(
                new Ingredient(
                    name: 'Butterscotch',
                    capacity: -1,
                    durability: -2,
                    flavor: 6,
                    texture: 3,
                    calories: 8
                ),
                new Volume(44, $dimension)
            )
        );
        $recipe->setIngredientMeasurement(
            new IngredientMeasurement(
                new Ingredient(
                    name: 'Cinnamon',
                    capacity: 2,
                    durability: 3,
                    flavor: -2,
                    texture: -1,
                    calories: 3
                ),
                new Volume(56, $dimension)
            )
        );

        self::assertRecipeHolds100Teaspoons($recipe);
    }
}
