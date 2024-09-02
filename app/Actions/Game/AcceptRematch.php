<?php

namespace App\Actions\Game;

use App\Events\RematchAccepted;
use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Pirsch\Facades\Pirsch;

class AcceptRematch
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        $game->resetGame();

        Pirsch::track(
            name: 'Rematch accepted',
            meta: [
                'game_id' => $game->id,
            ]
        );

        event(new RematchAccepted($game->id, $request->user()->id));
    }
}
