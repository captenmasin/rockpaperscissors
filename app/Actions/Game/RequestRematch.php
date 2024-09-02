<?php

namespace App\Actions\Game;

use App\Events\PlayerMoved;
use App\Events\RematchRequested;
use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Pirsch\Facades\Pirsch;

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
