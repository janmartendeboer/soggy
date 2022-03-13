<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Tests\Integration;

use Janmartendeboer\Soggy\Calculator\YummyCalculator;
use Janmartendeboer\Soggy\Finder\LinearRecipeFinder;
use Janmartendeboer\Soggy\Pantry\Pantry;
use Janmartendeboer\Soggy\Recipe\Ingredient;
use Janmartendeboer\Soggy\Recipe\IngredientMeasurement;
use Janmartendeboer\Soggy\Recipe\Recipe;
use Measurements\Dimension;
use Measurements\Quantities\Volume;
use Measurements\Units\UnitVolume;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class FindRecipeTest extends TestCase
{
    private const RECIPE_NAME = LinearRecipeFinder::RECIPE_NAME;

    use AssertsVolume;
    use AssertsRecipe;

    /**
     * @dataProvider dataProvider
     */
    public function testFindRecipe(
        Pantry $pantry,
        Dimension $dimension,
        Volume $targetVolume,
        ?Recipe $expectedRecipe,
        int $expectedScore = 0
    ): void {
        $calculator = new YummyCalculator($dimension);
        $finder = new LinearRecipeFinder($calculator, $targetVolume, $dimension);

        $result = $finder->findRecipe($pantry);

        if ($expectedRecipe === null) {
            self::assertNull($result, 'Should not result in a recipe.');
        } else {
            self::assertInstanceOf(Recipe::class, $result);
            self::assertRecipeHolds100Teaspoons($result);
            self::assertRecipeMatchesRecipe($expectedRecipe, $result);
            self::assertEquals(
                $expectedScore,
                $calculator->calculateScore($result),
                'Expected score must match actual score.'
            );
        }
    }

    public function dataProvider(): array
    {
        $dimension = UnitVolume::teaspoons();
        $targetVolume = new Volume(100, $dimension);

        return [
            [
                'pantry' => new Pantry(
                    new IngredientMeasurement(
                        new Ingredient(
                            name:       'Sprinkles',
                            capacity:   2,
                            durability: 0,
                            flavor:     -2,
                            texture:    0,
                            calories:   3
                        ),
                        $targetVolume
                    ),
                    new IngredientMeasurement(
                        new Ingredient(
                            name:       'Butterscotch',
                            capacity:   0,
                            durability: 5,
                            flavor:     -3,
                            texture:    0,
                            calories:   3
                        ),
                        $targetVolume
                    ),
                    new IngredientMeasurement(
                        new Ingredient(
                            name:       'Chocolate',
                            capacity:   0,
                            durability: 0,
                            flavor:     5,
                            texture:    -1,
                            calories:   8
                        ),
                        $targetVolume
                    ),
                    new IngredientMeasurement(
                        new Ingredient(
                            name:       'Candy',
                            capacity:   0,
                            durability: -1,
                            flavor:     0,
                            texture:    5,
                            calories:   8
                        ),
                        $targetVolume
                    )
                ),
                'dimension' => $dimension,
                'targetVolume' => $targetVolume,
                'expectedRecipe' => self::createRecipe(
                    new IngredientMeasurement(
                        new Ingredient(
                            name:       'Sprinkles',
                            capacity:   2,
                            durability: 0,
                            flavor:     -2,
                            texture:    0,
                            calories:   3
                        ),
                        new Volume(17, $dimension)
                    ),
                    new IngredientMeasurement(
                        new Ingredient(
                            name:       'Butterscotch',
                            capacity:   0,
                            durability: 5,
                            flavor:     -3,
                            texture:    0,
                            calories:   3
                        ),
                        new Volume(19, $dimension)
                    ),
                    new IngredientMeasurement(
                        new Ingredient(
                            name:       'Chocolate',
                            capacity:   0,
                            durability: 0,
                            flavor:     5,
                            texture:    -1,
                            calories:   8
                        ),
                        new Volume(38, $dimension)
                    ),
                    new IngredientMeasurement(
                        new Ingredient(
                            name:       'Candy',
                            capacity:   0,
                            durability: -1,
                            flavor:     0,
                            texture:    5,
                            calories:   8
                        ),
                        new Volume(26, $dimension)
                    )
                ),
                'expectedScore' => 21367368
            ]
        ];
    }

    private static function createRecipe(
        IngredientMeasurement ...$ingredients
    ): Recipe {
        $recipe = new Recipe(self::RECIPE_NAME);

        foreach ($ingredients as $ingredient) {
            $recipe->setIngredientMeasurement($ingredient);
        }

        return $recipe;
    }
}
