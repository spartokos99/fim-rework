<?php

namespace App\Filament\Resources\TeamCategories\Pages;

use App\Filament\Resources\TeamCategories\TeamCategoryResource;
use Filament\Actions\CreateAction;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Resources\Pages\TreePage;

class CategoryTree extends TreePage
{
    protected static string $resource = TeamCategoryResource::class;

    protected static int $maxDepth = 3;

    public function getTreeRecordTitle(?\Illuminate\Database\Eloquent\Model $record = null): string
    {
        if (!$record) return '';

        return "{$record->prefix} {$record->title}";
    }

    protected function getTreeToolbarActions(): array
    {
        return [];
    }
    
    protected function getTreeActions(): array
{
    return [
        EditAction::make()
            ->modal()
            ->form(fn ($form) => static::getResource()::form($form))
            ->modalHeading('Edit Category')
            ->modalWidth('lg'),
        DeleteAction::make()
            ->modalHeading('Delete Category')
            ->modalSubheading('Are you sure you want to delete this category? This action cannot be undone.')
            ->modalButton('Delete')
    ];
}

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->modal()
                ->form(fn ($form) => static::getResource()::form($form))
                ->modalHeading('Create Category')
                ->modalWidth('lg')
        ];
    }

    public function getMaxContentWidth(): string
    {
        return '7xl';
    }

    protected function hasDeleteAction(): bool
    {
        return true;
    }

    protected function hasEditAction(): bool
    {
        return true;
    }

    protected function hasViewAction(): bool
    {
        return false;
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    // public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    // {
    //     return null;
    // }
}
