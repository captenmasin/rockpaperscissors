<?php

namespace App\Actions\Game;

use App\Models\Game;
use Pirsch\Facades\Pirsch;
use Illuminate\Http\Request;
use App\Events\RematchDenied;
use Lorisleiva\Actions\Concerns\AsAction;

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
