<?php

namespace App\Actions\Game;

use App\Models\Article;
use App\Models\Game;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class NewGame
{
    use AsAction;

    public function handle(Request $request)
    {
        $uuid = $this->generateUuid();
        while (Game::where('uuid', $uuid)->exists()) {
            $uuid = $this->generateUuid();
        }

        $game = Game::create([
            'uuid' => $uuid,
            'player_one' => $request->user()->id,
        ]);

        Pirsch::track(
            name: 'Game created',
            meta: [
                'game_id' => $game->id,
            ]
        );

        return redirect()->route('game', $game);
    }


    public function generateUuid()
    {
        return (string) bin2hex(random_bytes(5));
    }
}
