<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Recipe\Rule;

use Janmartendeboer\Soggy\Calculator\CalculatorInterface;
use Janmartendeboer\Soggy\Recipe\Recipe;

class ExactScoreRule implements RuleInterface
{
    public function __construct(
        private int $score,
        private CalculatorInterface $calculator
    ) {}

    public function passes(Recipe $subject): bool
    {
        return $this->calculator->calculateScore($subject) === $this->score;
    }
}
