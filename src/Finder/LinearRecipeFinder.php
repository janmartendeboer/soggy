<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Finder;

use Generator;
use Janmartendeboer\Soggy\Calculator\CalculatorInterface;
use Janmartendeboer\Soggy\Pantry\Pantry;
use Janmartendeboer\Soggy\Recipe\Ingredient;
use Janmartendeboer\Soggy\Recipe\Recipe;
use Janmartendeboer\Soggy\Recipe\Rule\HasVolumeRule;
use Janmartendeboer\Soggy\Recipe\Rule\RuleInterface;
use Measurements\Dimension;
use Measurements\Measurement;
use Measurements\Quantities\Volume;

final class LinearRecipeFinder implements RecipeFinderInterface
{
    use CreatesDispersionMatrix;

    public const RECIPE_NAME = 'Linearly calculated recipe';

    public function __construct(
        private CalculatorInterface $calculator,
        private Measurement $targetVolume,
        private Dimension $dimension,
        private RuleInterface $rule = new HasVolumeRule()
    ) {}

    public function findRecipe(Pantry $pantry): ?Recipe
    {
        /** @var Ingredient[] $ingredients */
        $ingredients = $pantry->getAvailableIngredients();
        $targetUnits = (int)$this->targetVolume->convertTo($this->dimension)->value();

        $foundScore = 0;
        $foundRecipe = null;

        foreach ($this->createCandidates($pantry, $targetUnits, ...$ingredients) as $recipe) {
            $score = $this->calculator->calculateScore($recipe);

            if ($score > $foundScore || $foundRecipe === null) {
                $foundRecipe = $recipe;
                $foundScore = $score;
            }
        }

        return $foundRecipe;
    }

    /**
     * @return Generator&Recipe[]
     */
    private function createCandidates(
        Pantry $pantry,
        int $targetUnits,
        Ingredient ...$ingredients
    ): Generator {
        /** @var Ingredient[]|int[] $options */
        foreach (self::createDispersionMatrix($targetUnits, ...$ingredients) as $options) {
            $recipe = new Recipe(self::RECIPE_NAME);
            foreach ($options as [$ingredient, $amount]) {
                $recipe->setIngredientMeasurement(
                    $pantry->getIngredient(
                        $ingredient,
                        new Volume($amount, $this->dimension)
                    )
                );
            }

            if ($this->rule->passes($recipe)) {
                yield $recipe;
            }
        }
    }
}
