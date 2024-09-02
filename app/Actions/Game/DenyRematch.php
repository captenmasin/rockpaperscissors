<?php

namespace App\Actions\Game;

use App\Events\RematchAccepted;
use App\Events\RematchDenied;
use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class DenyRematch
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        event(new RematchDenied($game->id, $request->user()->id));
    }
}
