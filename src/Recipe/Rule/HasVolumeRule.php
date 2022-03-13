<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Recipe\Rule;

use Janmartendeboer\Soggy\Recipe\Recipe;

class HasVolumeRule implements RuleInterface
{
    public function passes(Recipe $subject): bool
    {
        return $subject->getVolume()->value() > 0;
    }
}
