<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Actions\Pages\Home::class)->name('home');

Route::get('game/new', App\Actions\Game\NewGame::class)->middleware('auth')->name('new-game');

Route::get('{game:uuid}', App\Actions\Pages\ShowGame::class)->name('game');
Route::post('/game/{game:uuid}/move', \App\Actions\Game\PlayerMove::class)->middleware('auth');
