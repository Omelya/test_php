<?php

namespace App\Http\Controllers;

use App\Services\History\HistoryService;
use Illuminate\Http\JsonResponse;

class HistoryController extends Controller
{
    public function index(HistoryService $historyService): JsonResponse
    {
        return response()->json([
            'data' => [$historyService->get()]
        ]);
    }
}
