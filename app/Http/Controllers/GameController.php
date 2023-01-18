<?php

namespace App\Http\Controllers;

use App\Services\History\HistoryService;
use Exception;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(HistoryService $historyService): JsonResponse
    {
        $randomNumber = random_int(0, 1000);
        $gain = 0;

        if ($randomNumber % 2 === 0) {
            $historyService->create($randomNumber, 'Lose', $gain);
            return response()->json([
                'data' => [
                    'number' => $randomNumber,
                    'status' => 'Lose',
                    'gain' => $gain
                ]
            ]);
        }

        switch ($randomNumber) {
            case $randomNumber > 900:
                $gain = $randomNumber * 0.7;
                break;
            case $randomNumber > 600:
                $gain = $randomNumber * 0.5;
                break;
            case $randomNumber > 300:
                $gain = $randomNumber * 0.3;
                break;
            case $randomNumber < 300:
                $gain = $randomNumber * 0.1;
                break;
        }

        $historyService->create($randomNumber, 'Win', $gain);

        return response()
            ->json([
                'data' => [
                    'number' => $randomNumber,
                    'status' => 'Win',
                    'gain' => round($gain, 1)
                ]
            ]);
    }
}
