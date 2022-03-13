<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Recipe\Rule;

use Janmartendeboer\Soggy\Recipe\Recipe;

class ChainRule implements RuleInterface
{
    /** @var RuleInterface[] */
    private array $rules;

    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    public function passes(Recipe $subject): bool
    {
        return array_reduce(
            $this->rules,
            fn (bool $carry, RuleInterface $rule) => $carry && $rule->passes($subject),
            count($this->rules) > 0
        );
    }
}
