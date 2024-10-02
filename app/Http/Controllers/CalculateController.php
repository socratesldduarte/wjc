<?php

namespace App\Http\Controllers;

use App\Services\WJCService;
use Illuminate\Http\Request;

class CalculateController extends Controller
{
    /**
     * Evaluate the WJC and return a json with all steps to complete.
     */
    public function evaluate(Request $request, WJCService $wjcService)
    {
        // TODO: VALIDATE INPUT
        return $wjcService->evaluate(
            $request->x_capacity,
            $request->y_capacity,
            $request->z_amount_wanted,
        );
    }
}
