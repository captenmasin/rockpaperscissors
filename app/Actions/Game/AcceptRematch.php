<?php

namespace App\Actions\Game;

use App\Models\Game;
use Pirsch\Facades\Pirsch;
use Illuminate\Http\Request;
use App\Events\RematchAccepted;
use Lorisleiva\Actions\Concerns\AsAction;

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
