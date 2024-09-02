<?php

namespace App\Actions\Game;

use App\Models\Game;
use Pirsch\Facades\Pirsch;
use Illuminate\Http\Request;
use App\Events\RematchRequested;
use Lorisleiva\Actions\Concerns\AsAction;

class RequestRematch
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        Pirsch::track(
            name: 'Rematch requested',
            meta: [
                'game_id' => $game->id,
            ]
        );

        event(new RematchRequested($game->id, $request->user()->id));
    }
}
