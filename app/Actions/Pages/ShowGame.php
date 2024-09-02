<?php

namespace App\Actions\Pages;

use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowGame
{
    use AsAction;

    public function handle(Request $request, Game $game)
    {
        if ($game->alreadyPlayed()){
            dd('Game already played, ' . $game->determineWinner() . ' won.');
        }

        if (empty($game->player_one)){
            $game->update(['player_one' => $request->user()->id]);
        }

        if (empty($game->player_two) && $game->player_one != $request->user()->id){
            $game->update(['player_two' => $request->user()->id]);
        }

        return Inertia::render('Game', [
            'game' => $game->only('id', 'uuid', 'player_one', 'player_two'),
        ]);
    }
}
