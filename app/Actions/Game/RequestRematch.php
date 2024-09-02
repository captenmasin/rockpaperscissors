<?php

namespace App\Actions\Game;

use App\Events\PlayerMoved;
use App\Events\RematchRequested;
use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class RequestRematch
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        event(new RematchRequested($game->id, $request->user()->id));
    }
}
