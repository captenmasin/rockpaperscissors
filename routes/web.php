<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Actions\Pages\Home::class)->name('home');

Route::get('game/new', App\Actions\Game\NewGame::class)->middleware('auth')->name('new-game');

Route::get('{game:uuid}', App\Actions\Pages\ShowGame::class)->name('game');
Route::post('/game/{game:uuid}/move', \App\Actions\Game\PlayerMove::class)->middleware('auth');
Route::post('/game/{game:uuid}/join', \App\Actions\Game\JoinGame::class)->middleware('auth');
Route::post('/game/{game:uuid}/rematch', \App\Actions\Game\RequestRematch::class)->middleware('auth');
Route::post('/game/{game:uuid}/rematch/accept', \App\Actions\Game\AcceptRematch::class)->middleware('auth');
Route::post('/game/{game:uuid}/rematch/deny', \App\Actions\Game\DenyRematch::class)->middleware('auth');
