<?php

use App\Models\Game;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('game.{id}', function ($user, $id) {
    $game = Game::find($id);

    return $game && ($game->player_one == $user->id || $game->player_two == $user->id);
});
