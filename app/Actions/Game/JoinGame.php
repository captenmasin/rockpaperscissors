<?php

namespace App\Actions\Game;

use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class JoinGame
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        if (!$request->user()) {
            return redirect()->route('home');
        }

        if ($game->finished()) {
            return redirect()->route('home');
        }

        if (empty($game->player_one)) {
            $game->update(['player_one' => $request->user()->id]);
        }

        if (empty($game->player_two) && $game->player_one !== $request->user()->id) {
            $game->update(['player_two' => $request->user()->id]);
        }

        return redirect()->back();
    }
}
