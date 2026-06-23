<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Str;

class TeamProfileForm
{
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Team Information')->components([
                    TextInput::make('name')
                        ->maxLength(30)->required()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('slug', Str::slug($state));
                        }),
                    TextInput::make('slug')
                        ->readOnly()
                        ->disabled()
                        ->saved(false)
                        ->hint('Will be automatically generated from the name')
                        ->unique(ignoreRecord: true),
                    ColorPicker::make('color')->default('#6b0707')->required(),
                    FileUpload::make('image')
                        ->image()
                        ->imageEditor(2)
                        ->imageAspectRatio('1:1')
                        ->imageEditorAspectRatioOptions([
                            '1:1' => '1:1'
                        ])
                        ->imageEditorEmptyFillColor('#000000')
                        ->automaticallyOpenImageEditorForAspectRatio()
                        ->automaticallyResizeImagesToHeight(500)
                        ->automaticallyResizeImagesToWidth(500)
                        ->automaticallyResizeImagesMode('cover')
                        ->maxSize(40960)
                        ->previewable(true)
                        ->disk('public')
                        ->visibility('public')
                        ->directory('teams/avatars'),
                    Textarea::make('description')->rows(3)->maxLength(255)->columnSpanFull(),
                ])->columns(2)
            ]);
    }
}