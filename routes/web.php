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

    $secondLayerCategories = TeamCategory::whereHas('parent', function ($query) {
        $query->doesntHave('parent');
    })->get();

    $thirdLayerCategories = TeamCategory::whereHas('parent', function ($query) {
        $query->has('parent');
    })->get();

    $return = [
        'team' => $team,
        'assets' => $assets,

        'flCats' => $firstLayerCategories,
        'slCats' => $secondLayerCategories,
        'tlCats' => $thirdLayerCategories,
    ];
    return view('FrontendPage', $return);
});