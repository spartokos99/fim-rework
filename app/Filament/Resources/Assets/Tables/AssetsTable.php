<?php

namespace App\Filament\Resources\Assets\Tables;

use App\Models\Asset;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Str;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->groups([
                'category.title',
                Group::make('published_status_for_grouping')
                    ->label('Published Status'),
            ])
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->square()
                    ->imageSize(fn () => session('table.image-size', 64))
                    ->toggleable(true, false)
                    ->grow(false),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('description')
                    ->formatStateUsing(fn ($state) => Str::limit(strip_tags($state), 60))
                    ->wrap(true)
                    ->color('gray')
                    ->html()
                    ->toggleable(true, false),
                TextColumn::make('category.title')
                    ->label('Category')
                    ->badge()
                    ->sortable(true)
                    ->searchable(true),
                TextColumn::make('tags')
                    ->color('info')
                    ->sortable(false)
                    ->searchable(true)
                    ->badge(),
                TextColumn::make('published_status')
                    ->label('Published?')
                    ->sortable(true)
                    ->searchable(true)
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $status = $record->publishedStatus();
                        if ($status instanceof Carbon) {
                            $diffText = $status->diffForHumans(now(), [
                                'short' => true,
                                'parts' => 2,
                                'syntax' => Carbon::DIFF_ABSOLUTE,
                            ]);
                        }
                        return ($status === 'published') ? 'Published' : ($status === 'unpublished' ? 'Unpublished' : $status->format('Y-m-d H:i') . ' (' . ($diffText ?? '') . ')');
                    })
                    ->color(function ($record) {
                        $status = $record->publishedStatus();
                        return ($status === 'published') ? 'success' : (($status === 'unpublished') ? 'danger' : 'warning');
                    }),
                TextColumn::make('created_at')->dateTime()->color('gray')->toggleable(true, true),
                TextColumn::make('updated_at')->dateTime()->color('gray')->toggleable(true, true),
            ])
            ->filters([
                SelectFilter::make('categories')->relationship('category', 'title')->multiple(),
                SelectFilter::make('tags')
                    ->label('Tag')
                    ->options(function () {
                        return collect(Asset::pluck('tags'))
                            ->map(fn($tagsJson) => is_array($tagsJson) ? $tagsJson : json_decode($tagsJson, true))
                            ->flatten()
                            ->unique()
                            ->sort()
                            ->mapWithKeys(fn($tag) => [$tag => $tag])
                            ->toArray();
                    })
                    ->query(function ($query, $values) {
                        if (empty($values)) {
                            return $query; // "All" ausgewählt
                        }

                        foreach ((array) $values as $tag) {
                            $query->whereJsonContains('tags', $tag);
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('7xl'),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
