<?php

namespace App\Filament\Resources\Assets\Pages;

use App\Filament\Resources\Assets\AssetResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListAssets extends ListRecords
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('tableSettings')
                ->label('Table Settings')
                ->form([
                    Select::make('image_size')
                        ->label('Image Size')
                        ->options([
                            32 => '32px',
                            48 => '48px',
                            64 => '64px',
                            96 => '96px',
                            128 => '128px',
                            256 => '256px',
                            512 => '512px',
                        ])
                        ->default(session('table.image-size', 64))
                ])
                ->action(function (array $data) {
                    session(['table.image-size' => $data['image_size']]);
                })
                ->modalWidth('md')
                ->outlined()
                ->color('primary'),
            CreateAction::make()
                ->modalWidth('7xl'),
        ];
    }
}
