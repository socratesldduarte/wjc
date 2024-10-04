<?php

namespace Tests\Unit;

use App\Services\WJCService;
use PHPUnit\Framework\TestCase;

class GcdTest extends TestCase
{
    public function test_num1_is_multiple_num2_gdc(): void
    {
        $service = new WJCService();
        $inputNum1 = 10;
        $inputNum2 = 2;

        $this->assertEquals($inputNum2, $service->gcd($inputNum1, $inputNum2));
    }

    public function test_num2_is_multiple_num1_gdc(): void
    {
        $service = new WJCService();
        $inputNum1 = 2;
        $inputNum2 = 10;

        $this->assertEquals($inputNum1, $service->gcd($inputNum1, $inputNum2));
    }

    public function test_non_multiples_gdc(): void
    {
        $service = new WJCService();
        $inputNum1 = 8;
        $inputNum2 = 12;
        $expected = 4;

        $this->assertEquals($expected, $service->gcd($inputNum1, $inputNum2));
    }

    public function test_no_generated_gdc(): void
    {
        $service = new WJCService();
        $inputNum1 = 3;
        $inputNum2 = 7;
        $expected = 1;

        $this->assertEquals($expected, $service->gcd($inputNum1, $inputNum2));
    }
}
