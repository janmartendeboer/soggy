<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Recipe\Rule;

use Janmartendeboer\Soggy\Recipe\Recipe;

interface RuleInterface
{
    public function passes(Recipe $subject): bool;
}
