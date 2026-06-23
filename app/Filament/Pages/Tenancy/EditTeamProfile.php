<?php

namespace App\Filament\Pages\Tenancy;

use App\Filament\Widgets\TeamMembersStats;
use App\Models\Team;
use Filament\Facades\Filament;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Schema;
use App\Filament\Forms\TeamProfileForm;

class EditTeamProfile extends EditTenantProfile
{   
    public static function getLabel(): string
    {
        return 'Team profile';
    }

    public function form(Schema $schema): Schema
    {
        return TeamProfileForm::form($schema);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TeamMembersStats::class
        ];
    }

    public function getMaxContentWidth(): string
    {
        return '7xl';
    }

    protected function getRedirectUrl(): string|null
    {
        return route('filament.admin.tenant.profile', ['tenant' => Filament::getTenant()->fresh()->slug]);
    }
}