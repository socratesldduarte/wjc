<?php

namespace App\Http\Controllers;

use App\Services\WJCService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalculateController extends Controller
{
    /**
     * Evaluate the WJC and return a json with all steps to complete.
     */
    public function evaluate(Request $request, WJCService $wjcService)
    {
        $request->validate([
            'x_capacity' => 'required|int|min:1',
            'y_capacity' => 'required|int|min:1',
            'z_amount_wanted' => 'required|int|min:1',
        ]);
        return $wjcService->evaluate(
            $request->x_capacity,
            $request->y_capacity,
            $request->z_amount_wanted,
        );
    }
}
