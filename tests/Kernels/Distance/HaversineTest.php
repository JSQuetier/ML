<?php

namespace Rubix\ML\Tests\Kernels\Distance;

use Rubix\ML\Kernels\Distance\Haversine;
use Rubix\ML\Kernels\Distance\Distance;
use PHPUnit\Framework\TestCase;
use Generator;

/**
 * @group Distances
 * @covers \Rubix\ML\Kernels\Distance\Euclidean
 */
class HaversineTest extends TestCase
{
    /**
     * @var Haversine
     */
    protected $kernel;

    /**
     * @before
     */
    protected function setUp() : void
    {
        $this->kernel = new Haversine();
    }

    /**
     * @test
     */
    public function build() : void
    {
        $this->assertInstanceOf(Haversine::class, $this->kernel);
        $this->assertInstanceOf(Distance::class, $this->kernel);
    }

    /**
     * @test
     * @dataProvider computeProvider
     *
     * @param (int|float)[] $a
     * @param (int|float)[] $b
     * @param float $expected
     */
    public function compute(array $a, array $b, float $expected) : void
    {
        $distance = $this->kernel->compute($a, $b);

        $this->assertGreaterThanOrEqual(0., $distance);
        $this->assertEquals($expected, $distance);
    }

    /**
     * @return \Generator<mixed[]>
     */
    public function computeProvider() : Generator
    {
        yield [
            [0,0], [0,0],
            0,
        ];

        yield [ // PARIS <-> NY
            [48.8575,2.3514], [40.7127,-74.0059],
            5837.1491944886475,
        ];

        yield [ // MELBOURNE <-> TOKYO
            [-37.8140,144.9633], [35.6895,139.6917],
            8191.241177807441,
        ];

        yield [ // LIMA <-> BRASÍLIA
            [-12.0431,-77.0282], [-15.7797,-47.9297],
            3165.4255905780933,
        ];

        yield [ // LONDON <-> LONDON
            [51.50735,-0.1277], [51.50735,-0.1277],
            0,
        ];

        yield [ // BAD DATAS
            [51.50735], [51.50735,-0.1277],
            0,
        ];

        yield [ // BAD DATAS AGAIN
            [51.50735,-0.1277], [-0.1277],
            0,
        ];        
    }
}
