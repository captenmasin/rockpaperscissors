<?php

namespace App\Actions\Game;

use App\Events\RematchAccepted;
use App\Events\RematchRequested;
use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class AcceptRematch
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        $game->resetGame();

        event(new RematchAccepted($game->id, $request->user()->id));
    }
}
