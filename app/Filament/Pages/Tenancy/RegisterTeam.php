<?php

namespace App\Filament\Pages\Tenancy;

use App\Filament\Forms\TeamProfileForm;
use App\Models\Team;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register team';
    }

    public function form(Schema $schema): Schema
    {
        return TeamProfileForm::form($schema);
    }

    protected function handleRegistration(array $data): Team
    {
        $team = Team::create($data + [
            'owner_id' => auth()->id(),
            'slug' => \Str::slug($data['name']),
        ]);
        $team->members()->attach(auth()->user());

        return $team;
    }

    public function getMaxContentWidth(): string
    {
        return '7xl';
    }
}