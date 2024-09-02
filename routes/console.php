<?php

use App\Actions\Game\DeleteOldGames;
use Illuminate\Support\Facades\Schedule;

Schedule::command(DeleteOldGames::class)->daily();

\Illuminate\Support\Facades\Artisan::command('generate-route-types', function () {
    $routeNames = collect(\Route::getRoutes())->map(fn ($route) => $route->getName())->filter()->unique()->values();

    $enumFile = 'const RouteNames = [';
    $routeTypes = $routeNames->map(function ($routeName) {
        return "\"$routeName\",";
    })->implode("\n");
    $enumFile .= $routeTypes."\n] as const \n\nexport type RouteName = typeof RouteNames[number];";

    file_put_contents(resource_path('js/Types/Routes.d.ts'), $enumFile);
});
