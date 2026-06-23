<?php

namespace App\Filament\Resources\TeamCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Str;
use TangoDevIt\FilamentEmojiPicker\EmojiPickerAction;

class TeamCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->required()
                ->maxLength(30)
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('slug', Str::slug($state));
                }),
            TextInput::make('slug')
                ->readOnly()
                ->disabled()
                ->saved(false)
                ->hint('Will be automatically generated from the name')
                ->scopedUnique(),
            Textarea::make('description')
                ->columnSpanFull()
                ->rows(3)
                ->maxLength(255),
            TextInput::make('prefix')
                ->maxLength(10)
                ->suffixAction(EmojiPickerAction::make('icon')),
        ]);
    }
}