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
                "Recipe:\t[Volume: %s]\t[Score: %d]\t%s",
                $recipe->getVolume(),
                $result,
                json_encode($recipe)
            )
        );

        return $result;
    }
}
