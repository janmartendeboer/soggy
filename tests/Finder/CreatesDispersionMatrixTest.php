<?php

declare(strict_types=1);

namespace Janmartendeboer\Soggy\Tests\Finder;

use PHPUnit\Framework\TestCase;
use Janmartendeboer\Soggy\Finder\CreatesDispersionMatrix;

/**
 * @coversDefaultClass \Janmartendeboer\Soggy\Finder\CreatesDispersionMatrix
 */
class CreatesDispersionMatrixTest extends TestCase
{
    use CreatesDispersionMatrix;

    /**
     * @dataProvider dataProvider
     *
     * @covers ::createDispersionMatrix
     */
    public function testCreateDispersionMatrix(
        int $total,
        array $axes,
        array $expected
    ): void {
        self::assertMatrixEqualsMatrix(
            $expected,
            iterator_to_array(
                self::createDispersionMatrix($total, ...$axes)
            )
        );
    }

    private static function assertMatrixEqualsMatrix(
        array $expected,
        array $actual,
        string $message = null
    ): void {
        self::assertJsonStringEqualsJsonString(
            json_encode($expected),
            json_encode($actual),
            $message ?? ''
        );
    }

    public function dataProvider(): array
    {
        return [
            'Empty result' => [
                'total' => 100,
                'axes' => [],
                'expected' => []
            ],
            'Single row, 1 axis' => [
                'total' => 100,
                'axes' => ['foo'],
                'expected' => [
                    [['foo', 100]]
                ]
            ],
            'Single row, 2 axes' => [
                'total' => 0,
                'axes' => ['foo', 'bar'],
                'expected' => [
                    [['foo', 0], ['bar', 0]]
                ]
            ],
            'Multiple rows, 2 axes' => [
                'total' => 3,
                'axes' => ['foo', 'bar'],
                'expected' => [
                    [['foo', 3], ['bar', 0]],
                    [['foo', 2], ['bar', 1]],
                    [['foo', 1], ['bar', 2]],
                    [['foo', 0], ['bar', 3]]
                ]
            ],
            'Multiple rows, 3 axes' => [
                'total' => 5,
                'axes' => ['foo', 'bar', 'baz'],
                'expected' => [
                    [['foo', 5], ['bar', 0], ['baz', 0]],
                    [['foo', 4], ['bar', 1], ['baz', 0]],
                    [['foo', 4], ['bar', 0], ['baz', 1]],
                    [['foo', 3], ['bar', 2], ['baz', 0]],
                    [['foo', 3], ['bar', 1], ['baz', 1]],
                    [['foo', 3], ['bar', 0], ['baz', 2]],
                    [['foo', 2], ['bar', 3], ['baz', 0]],
                    [['foo', 2], ['bar', 2], ['baz', 1]],
                    [['foo', 2], ['bar', 1], ['baz', 2]],
                    [['foo', 2], ['bar', 0], ['baz', 3]],
                    [['foo', 1], ['bar', 4], ['baz', 0]],
                    [['foo', 1], ['bar', 3], ['baz', 1]],
                    [['foo', 1], ['bar', 2], ['baz', 2]],
                    [['foo', 1], ['bar', 1], ['baz', 3]],
                    [['foo', 1], ['bar', 0], ['baz', 4]],
                    [['foo', 0], ['bar', 5], ['baz', 0]],
                    [['foo', 0], ['bar', 4], ['baz', 1]],
                    [['foo', 0], ['bar', 3], ['baz', 2]],
                    [['foo', 0], ['bar', 2], ['baz', 3]],
                    [['foo', 0], ['bar', 1], ['baz', 4]],
                    [['foo', 0], ['bar', 0], ['baz', 5]],
                ]
            ]
        ];
    }
}
