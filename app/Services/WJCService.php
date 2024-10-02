<?php

namespace App\Services;

use http\Client\Response;
use Illuminate\Http\JsonResponse;

class WJCService
{
    protected function gcd(int $x, int $y): int {
        while ($y != 0) {
            $temp = $y;
            $y = $x % $y;
            $x = $temp;
        }
        return $x;
    }

    protected function hasSolution($x, $y, $z): bool {
        return (($z % $this->gcd($x, $y)) == 0);
    }

    public function evaluate(int $x, int $y, int $z): JsonResponse {
        if (!$this->hasSolution($x, $y, $z)) {
            return response()->json([
                'message' => 'No Solution',
                'data' => [],
            ], 404);
        }
        // TODO: BUILD THE SOLUTION
        return response()->json([
            'message' => 'Successful evaluation',
            'data' => 'solution content (to be filled)',
        ], 200);
    }
}
