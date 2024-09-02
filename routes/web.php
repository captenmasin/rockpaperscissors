<?php

use App\Actions\Game\JoinGame;
use App\Actions\Game\PlayerMove;
use App\Actions\Game\DenyRematch;
use App\Actions\Game\AcceptRematch;
use App\Actions\Game\RequestRematch;
use Illuminate\Support\Facades\Route;

Route::get('/', App\Actions\Pages\Home::class)->name('home');

Route::get('game/new', App\Actions\Game\NewGame::class)->middleware('auth')->name('game.new');

Route::get('{game:uuid}', App\Actions\Pages\ShowGame::class)->name('game');

Route::prefix('game/{game:uuid}')->name('game.')->group(function () {
    Route::post('move', PlayerMove::class)->name('move')->middleware('auth');
    Route::post('join', JoinGame::class)->name('join')->middleware('auth');
    Route::post('rematch', RequestRematch::class)->name('rematch')->middleware('auth');
    Route::post('rematch/accept', AcceptRematch::class)->name('rematch.accept')->middleware('auth');
    Route::post('rematch/deny', DenyRematch::class)->name('rematch.deny')->middleware('auth');
})->middleware('auth');
