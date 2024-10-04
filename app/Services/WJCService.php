<?php

namespace App\Services;

use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class WJCService
{
    public function gcd(int $x, int $y): int {
        while ($y != 0) {
            $temp = $y;
            $y = $x % $y;
            $x = $temp;
        }
        return $x;
    }

    public function hasSolution($x, $y, $z): bool {
        return (($z % $this->gcd($x, $y)) == 0);
    }

    protected function buildResponse(
        bool $success,
        string $message,
        array $data,
        int $code,
    ): JsonResponse {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function evaluate(int $x, int $y, int $z): JsonResponse {
        if (!$this->hasSolution($x, $y, $z)) {
            return $this->buildResponse(false, 'No Solution', [], 200);
        }

        if ($cached = Cache::get($x . ";". $y . ";" . $z)) {
            return response()->json([
                'solution' => $cached
            ], 200);
        }

        // BTS Algorithm adaptation
        $visited = [];
        $queue = [[0, 0]];
        $path = ['0,0' => null];

        while (count($queue) > 0) {
            list($current_x, $current_y) = array_shift($queue);
            if ($current_x == $z || $current_y == $z) {
                $result = [];
                $current_state = [$current_x, $current_y];
                while ($current_state !== null) {
                    $new_item = $path[implode(",", $current_state)];
                    if (is_null($new_item)) {
                        $current_state = null;
                    } else {
                        array_push($result, array_merge($current_state, [$new_item['action']]));
                        $current_state = array_slice($new_item, 0, 2);
                    }
                }
                $response = [];
                $count = 0;
                foreach (array_reverse($result) as $step) {
                    $count++;
                    $response[] = [
                        'step' => $count,
                        'bucketX' => $step[0],
                        'bucketY' => $step[1],
                        'action' => $step[2],
                    ];
                }
                if ($count > 0) {
                    $response[$count - 1]['status'] = 'solved';
                }
                Cache::forever($x . ";". $y . ";" . $z, $response);
                return response()->json([
                    'solution' => $response
                ], 200);
            }

            if (in_array([$current_x, $current_y], $visited)) {
                continue;
            }

            array_push($visited, [$current_x, $current_y]);

            $states = [
                [$x, $current_y, 'Fill bucket X'],
                [$current_x, $y, 'Fill bucket Y'],
                [0, $current_y, 'Empty bucket X'],
                [$current_x, 0, 'Empty bucket Y'],
                [min($x, $current_x + $current_y), $current_x + $current_y - min($x, $current_x + $current_y), 'Transfer from bucket Y to bucket X'],
                [$current_x + $current_y - min($y, $current_x + $current_y), min($y, $current_x + $current_y), 'Transfer from bucket X to bucket Y'],
            ];

            foreach ($states as $state) {
                if (!in_array(array_slice($state, 0, 2), $visited)) {
                    array_push($queue, array_slice($state, 0, 2));
                    $path[implode(",", array_slice($state, 0, 2))] = [$current_x, $current_y, 'action' => $state[2]];
                }
            }
        }

        return $this->buildResponse(false, 'Wrong evaluation', ['solution not found'], 200);
    }
}
