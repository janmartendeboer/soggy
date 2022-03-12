<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Calculator;

use Janmartendeboer\Soggy\Recipe\Recipe;
use Psr\Log\LoggerInterface;

final class LoggerCalculator implements CalculatorInterface
{
    public function __construct(
        private CalculatorInterface $decorated,
        private LoggerInterface $logger
    ) {}

    public function calculateScore(Recipe $recipe): int
    {
        $result = $this->decorated->calculateScore($recipe);

        $this->logger->info(
            sprintf(
                "Recipe:\t%s\t[Score: %d]",
                json_encode($recipe),
                $result
            )
        );

        return $result;
    }
}
