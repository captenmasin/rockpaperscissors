<?php

namespace App\Actions\Game;

use App\Events\RematchAccepted;
use App\Events\RematchDenied;
use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Pirsch\Facades\Pirsch;

class DenyRematch
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        Pirsch::track(
            name: 'Rematch denied',
            meta: [
                'game_id' => $game->id,
            ]
        );

        event(new RematchDenied($game->id, $request->user()->id));
    }
}
