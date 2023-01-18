<?php

namespace App\Services\History;

use App\Models\History;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class HistoryService
{
    public function create(int $number, string $status, int $gain): void
    {
        History::create([
            'user_id' => Auth::user()->id,
            'number' => $number,
            'game_status' => $status,
            'gain' => $gain
        ]);
    }

    public function get(): Collection
    {
        return History
            ::query()
            ->where('user_id', Auth::user()->id)
            ->latest('created_at')
            ->limit(3)
            ->get();
    }
}
