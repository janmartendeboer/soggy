<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Tests\Integration;

use Janmartendeboer\Soggy\Calculator\CalculatorInterface;
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
final class FindRecipeTest extends TestCase
{
    use AssertsVolume;
    use AssertsRecipe;

    private static CalculatorInterface $calculator;
    private static Pantry $pantry;
    private static Volume $targetVolume;
    private static Dimension $dimension;

    protected function setUp(): void
    {
        self::$dimension = UnitVolume::teaspoons();
        self::$targetVolume = new Volume(100, self::$dimension);
        self::$calculator = new YummyCalculator(self::$dimension);
        self::$pantry = new Pantry(
            new IngredientMeasurement(
                new Ingredient(
                    name: 'Sprinkles',
                    capacity: 2,
                    durability: 0,
                    flavor: -2,
                    texture: 0,
                    calories: 3
                ),
                self::$targetVolume
            ),
            new IngredientMeasurement(
                new Ingredient(
                    name: 'Butterscotch',
                    capacity: 0,
                    durability: 5,
                    flavor: -3,
                    texture: 0,
                    calories: 3
                ),
                self::$targetVolume
            ),
            new IngredientMeasurement(
                new Ingredient(
                    name: 'Chocolate',
                    capacity: 0,
                    durability: 0,
                    flavor: 5,
                    texture: -1,
                    calories: 8
                ),
                self::$targetVolume
            ),
            new IngredientMeasurement(
                new Ingredient(
                    name: 'Candy',
                    capacity: 0,
                    durability: -1,
                    flavor: 0,
                    texture: 5,
                    calories: 8
                ),
                self::$targetVolume
            )
        );
    }

    public function testFindingThePerfectRecipe(): void
    {
        $expected = new Recipe(LinearRecipeFinder::RECIPE_NAME);

        $finder = new LinearRecipeFinder(self::$calculator, self::$targetVolume, self::$dimension);
        $result = $finder->findRecipe(self::$pantry);
        self::assertRecipeMatchesRecipe($expected, $result);
        self::assertRecipeHolds100Teaspoons($result);
    }
}
