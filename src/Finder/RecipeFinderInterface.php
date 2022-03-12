<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Finder;

use Janmartendeboer\Soggy\Pantry\Pantry;
use Janmartendeboer\Soggy\Recipe\Recipe;

interface RecipeFinderInterface
{
    public function findRecipe(Pantry $pantry): ?Recipe;
}
