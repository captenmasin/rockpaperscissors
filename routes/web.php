<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Actions\Pages\Home::class)->name('home');
Route::get('{game:uuid}', App\Actions\Pages\ShowGame::class)->name('game');
Route::post('/game/{game:uuid}/move', \App\Actions\Game\PlayerMove::class)->middleware('auth');
