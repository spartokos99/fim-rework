<?php

namespace App\Filament\Resources\TeamCategories;

use App\Filament\Resources\TeamCategories\Pages\CreateTeamCategory;
use App\Filament\Resources\TeamCategories\Pages\EditTeamCategory;
use App\Filament\Resources\TeamCategories\Pages\ListTeamCategories;
use App\Filament\Resources\TeamCategories\Schemas\TeamCategoryForm;
use App\Filament\Resources\TeamCategories\Tables\TeamCategoriesTable;
use App\Models\TeamCategory;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TeamCategoryResource extends Resource
{
    protected static ?string $model = TeamCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $recordTitleAttribute = 'name';

    protected static UnitEnum|string|null $navigationGroup = 'Resources';

    protected static ?string $slug = 'categories';

    protected static ?string $modelLabel = 'Category';

    public static function form(Schema $schema): Schema
    {
        return TeamCategoryForm::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CategoryTree::route('/')
        ];
    }
}
