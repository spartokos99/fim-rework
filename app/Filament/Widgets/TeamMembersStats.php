<?php

namespace App\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TeamMembersStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $record = Filament::getTenant();

        return [
            Stat::make('Members', $record?->members()->count() ?? 0)
                ->description('Total team members')
                ->color('primary'),
        ];
    }
}
