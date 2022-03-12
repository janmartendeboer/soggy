<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Recipe;

final class Ingredient
{
    public function __construct(
        public readonly string $name,
        public readonly int $capacity,
        public readonly int $durability,
        public readonly int $flavor,
        public readonly int $texture,
        public readonly int $calories
    ) {}
}
