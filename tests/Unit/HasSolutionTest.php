<?php

namespace Tests\Unit;

use App\Services\WJCService;
use PHPUnit\Framework\TestCase;

class HasSolutionTest extends TestCase
{
    public function test_below_bounds_solution(): void
    {
        $service = new WJCService();
        $xBucket = 10;
        $yBucket = 2;
        $zAmountWanted = 1;

        $this->assertFalse($service->hasSolution($xBucket, $yBucket, $zAmountWanted));
    }

    public function test_above_bounds_solution(): void
    {
        $service = new WJCService();
        $xBucket = 10;
        $yBucket = 2;
        $zAmountWanted = 15;

        $this->assertFalse($service->hasSolution($xBucket, $yBucket, $zAmountWanted));
    }

    public function test_has_solution(): void
    {
        $service = new WJCService();
        $xBucket = 10;
        $yBucket = 2;
        $zAmountWanted = 4;

        $this->assertTrue($service->hasSolution($xBucket, $yBucket, $zAmountWanted));
    }

    public function test_has_no_solution(): void
    {
        $service = new WJCService();
        $xBucket = 10;
        $yBucket = 2;
        $zAmountWanted = 5;

        $this->assertFalse($service->hasSolution($xBucket, $yBucket, $zAmountWanted));
    }
}
