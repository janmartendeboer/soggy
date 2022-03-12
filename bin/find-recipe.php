#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Janmartendeboer\Soggy\Calculator\LoggerCalculator;
use Janmartendeboer\Soggy\Calculator\YummyCalculator;
use Janmartendeboer\Soggy\Finder\LinearRecipeFinder;
use Janmartendeboer\Soggy\Pantry\Pantry;
use Janmartendeboer\Soggy\Recipe\Ingredient;
use Janmartendeboer\Soggy\Recipe\IngredientMeasurement;
use Measurements\Quantities\Volume;
use Measurements\Units\UnitVolume;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

$dimension = UnitVolume::teaspoons();
$targetVolume = new Volume(100, $dimension);

$pantry = new Pantry(
    new IngredientMeasurement(
        new Ingredient(
            name: 'Sprinkles',
            capacity: 2,
            durability: 0,
            flavor: -2,
            texture: 0,
            calories: 3
        ),
        $targetVolume
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
        $targetVolume
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
        $targetVolume
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
        $targetVolume
    )
);

$calculator = new LoggerCalculator(
    new YummyCalculator($dimension),
    new ConsoleLogger(
        new ConsoleOutput(OutputInterface::VERBOSITY_VERY_VERBOSE)
    )
);
$finder = new LinearRecipeFinder($calculator, $targetVolume, $dimension);
$result = $finder->findRecipe($pantry);
