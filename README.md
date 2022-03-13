# Soggy

Today, you set out on the task of perfecting your milk-dunking cookie recipe. All you have to do is find the right balance of ingredients.

Your recipe leaves room for exactly **100 teaspoons** of ingredients. You make a list of the remaining ingredients you could use to finish the recipe (your puzzle input) and their properties per teaspoon:

| Property     | Description |
|:-------------|:------------|
| *capacity*   | How well it helps the cookie absorb milk. |
| *durability* | How well it keeps the cookie intact when full of milk. |
| *flavor*     | How tasty it makes the cookie. |
| *texture*    | How it improves the feel of the cookie. |
| *calories*   | How many calories it adds to the cookie. |

You can only measure ingredients in whole-teaspoon amounts accurately, and you have to be accurate so you can reproduce your results in the future. The total score of a cookie can be found by adding up each of the properties (negative totals become 0) and then multiplying together everything except calories.

For instance, suppose you have these two ingredients:

- Butterscotch:
   - capacity: -1
   - durability: -2
   - flavor: 6
   - texture: 3
   - calories: 8
- Cinnamon:
   - capacity: 2
   - durability: 3
   - flavor: -2
   - texture: -1
   - calories: 3

Then, choosing to use 44 teaspoons of butterscotch and 56 teaspoons of cinnamon (because the amounts of each ingredient **must add up to 100**) would result in a cookie with the following properties:

- A capacity of 44*-1 + 56*2 = 68
- A durability of 44*-2 + 56*3 = 80
- A flavor of 44*6 + 56*-2 = 152
- A texture of 44*3 + 56*-1 = 76

Multiplying these together (68 * 80 * 152 * 76, ignoring calories for now) results in a total score of `62842880`, which happens to be the best score possible given these ingredients. If any properties had produced a negative total, it would have instead become zero, causing the whole score to multiply to zero.

Given the ingredients in your kitchen and their properties, what is the total score of the highest-scoring cookie you can make?

# Part Two, for bonus points :)

Your cookie recipe becomes wildly popular! Someone asks if you can make another recipe that has exactly `500` calories per cookie (so they can use it as a meal replacement). Keep the rest of your award-winning process the same (`100` teaspoons, same ingredients, same scoring system).

For example, given the ingredients above, if you had instead selected 40 teaspoons of butterscotch and 60 teaspoons of cinnamon (which still adds to 100), the total calorie count would be 40*8 + 60*3 = 500. The total score would go down, though: only `57600000`, the best you can do in such trying circumstances.

Given the ingredients in your kitchen and their properties, what is the total score of the highest-scoring cookie you can make with a calorie total of 500?

# Puzzle input

| Ingredient   | Capacity | Durability | Flavor | Texture | Calories |
|:-------------|---------:|-----------:|-------:|--------:|---------:|
| Sprinkles    | `2`      | `0`        | `-2`   | `0`     | `3`      |
| Butterscotch | `0`      | `5`        | `-3`   | `0`     | `3`      |
| Chocolate    | `0`      | `0`        | `5`    | `-1`    | `8`      |
| Candy        | `0`      | `-1`       | `0`    | `5`     | `8`      |

# Installation

In order to install the software to find the perfect milk-dunking cookie recipe,
the following requirements must be met:

- `PHP >= PHP 8.1` with `ext-json` enabled
- `Composer 1.x or Composer 2.x`

To install the dependencies, run:

```bash
composer install
```

# Usage

If developer requirements are installed, simply running `vendor/bin/phpunit` will
run all tests and verify the previously found recipe and score.

To manually run the recipe finder, invoke `bin/find-recipe.php`. It is set to
look for the meal replacement recipe. By removing or commenting the following
line, the finder will also look for recipes that aren't exactly 500 calories.

```php
new ExactScoreRule(500, new CaloriesCalculator($dimension))
```

**N.B.:** The script has a logging mechanism enabled, that outputs a line for
each recipe that gets its score calculated. This greatly impacts the speed at
which the script can run, due communication with output buffers, terminal buffers
and potentially even network layers. Do not assess the performance of the
calculators and finders based on timing that script. Instead, try running the
integration tests that document the found results, as documented under the next
heading.

# Results

The found results are documented in:

- `\Janmartendeboer\Soggy\Tests\Integration\FindRecipeTest`
- `\Janmartendeboer\Soggy\Tests\Integration\FindMealReplacementTest`

One can run them individually by invoking:

- ```bash
  vendor/bin/phpunit tests/Integration/FindRecipeTest.php
  ```
- ```bash
  vendor/bin/phpunit tests/Integration/FindMealReplacementTest.php
  ```
