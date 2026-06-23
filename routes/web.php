<?php

use App\Models\Team;
use App\Models\TeamCategory;
use Illuminate\Support\Facades\Route;

Route::get('{slug}', function ($slug) {
    $team = Team::where('slug', $slug)->firstOrFail();
    $assets = $team->assets();

    $firstLayerCategories = TeamCategory::query()
        ->whereHas('assets', fn($q) => $q->where('team_id', $team->id))
        ->doesntHave('parent')
        ->get();

    $secondLayerCategories = TeamCategory::query()
        ->whereHas('assets', fn($q) => $q->where('team_id', $team->id))
        ->whereHas('parent', fn($q) => $q->whereNull('parent_id'))
        ->get();

    $thirdLayerCategories = TeamCategory::query()
        ->whereHas('assets', fn($q) => $q->where('team_id', $team->id))
        ->whereHas('parent.parent')
        ->doesntHave('children')
        ->get();


    return view('FrontendPage', [
        'team' => $team,
        'assets' => $assets,

        'flCats' => $firstLayerCategories,
        'slCats' => $secondLayerCategories,
        'tlCats' => $thirdLayerCategories,
    ]);
});