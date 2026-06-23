<?php

namespace App\Filament\Resources\Assets\Schemas;

use App\Models\Asset;
use App\Models\TeamCategory;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Str;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make([
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
                        Select::make('category_id')
                            ->label('Category')
                            ->options(function () {
                                $categories = TeamCategory::query()
                                    ->where('team_id', filament()->getTenant()->id)
                                    ->where('parent_id', -1)
                                    ->with('children.children')
                                    ->orderBy('order')
                                    ->get();

                                return static::getCategoryOptions($categories);
                            })
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TagsInput::make('tags')
                            ->label('Tags')
                            ->placeholder('Add a tag and press enter')
                            ->tagPrefix('#')
                            ->hint('Max. 5 Tags')
                            ->trim()
                            ->rules([
                                'max:5'
                            ])
                            ->live()
                            ->reactive()
                            ->suggestions(function () {
                                $tags = Asset::query()
                                    ->where('team_id', Filament::getTenant()->id)
                                    ->pluck('tags')
                                    ->filter()
                                    ->map(fn($tagsJson) => is_array($tagsJson) ? $tagsJson : json_decode($tagsJson, true))
                                    ->flatten()
                                    ->unique()
                                    ->values()
                                    ->toArray();

                                return $tags;
                            })
                    ])->grow(true),
                    Section::make([
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
                            ->directory('assets/images')
                    ])
                ])->columnSpanFull()->from('md'),
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Description')
                            ->icon(Heroicon::DocumentText)
                            ->schema([
                                RichEditor::make('description')
                                    ->hiddenLabel(true)
                                    ->maxLength(1000)
                                    ->fileAttachments(false)
                                    ->live()
                                    ->reactive()
                                    ->hint(fn ($state, $component) => 'Characters: ' . strlen($state) . '/' . $component->getMaxLength())
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Variants, Prices, Quantities')
                            ->icon(Heroicon::CurrencyEuro)
                            ->badge(fn (callable $get) => count($get('variants') ?? []) ?: null)
                            ->schema([
                                Repeater::make('variants')
                                    ->columnSpanFull()
                                    ->defaultItems(0)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->label('Name (eg.: Sizes, Box, Jar, Gram, ...)')
                                            ->maxLength(20),
                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->required(),
                                        Checkbox::make('show_warning')
                                            ->label('Show warning for low stock')
                                            ->reactive()
                                            ->helperText('Set a warning level for low stock. You will receive a notification when the quantity reaches this level.')
                                            ->afterStateUpdated(function (callable $set, ?bool $state) {
                                                if (!$state) {
                                                    $set('warning_level', null);
                                                }
                                            }),
                                        TextInput::make('warning_level')
                                            ->numeric()
                                            ->minValue(0)
                                            ->step(1)
                                            ->label('Warning Level (eg.: 10, 100, ...)')
                                            ->default(20)
                                            ->disabled(fn (callable $get) => ! $get('show_warning')),
                                        Repeater::make('prices')
                                            ->required()
                                            ->columnSpanFull()
                                            ->schema([
                                                TextInput::make('amount')
                                                    ->numeric()
                                                    ->required()
                                                    ->label('Amount/Per'),
                                                Select::make('currency')
                                                    ->options([
                                                        '$' => 'USD',
                                                        '€' => 'EUR',
                                                        '£' => 'GBP',
                                                        'BTC' => 'Bitcoin (BTC)',
                                                        'ETH' => 'Ethereum (ETH)',
                                                        'USDT' => 'Tether (USDT)',
                                                        'SOL' => 'Solana (SOL)',
                                                        'BNB' => 'BNB (BNB)',
                                                        'XRP' => 'XRP (XRP)',
                                                    ])
                                                    ->required()
                                                    ->default('€'),
                                                TextInput::make('price')
                                                    ->numeric()
                                                    ->required(),
                                            ])->columns(3),
                                        ])
                                        ->columns(2)
                            ])
                    ])->columnSpanFull(),
                Section::make('Publishing')
                    ->description('Set the publishing date and time for the asset. You can also set a hide date to automatically unpublish the asset after a certain date.')
                    ->collapsible()
                    ->collapsed(false)
                    ->columnSpanFull()
                    ->schema([
                        DateTimePicker::make('publish_at')
                            ->label('Publish At')
                            ->reactive()
                            ->seconds(false),
                        DateTimePicker::make('hide_at')
                            ->label('Hide At')
                            ->seconds(false),
                        Checkbox::make('publish_now')
                            ->label('Publish Now')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, ?bool $state) {
                                if ($state) {
                                    $set('publish_at', now());
                                    $set('hide_at', null);
                                } else {
                                    $set('publish_at', null);
                                }
                            }),
                        Checkbox::make('hide_now')
                            ->label('Hide Now')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, ?bool $state) {
                                if ($state) {
                                    $set('hide_at', now());
                                    $set('publish_at', null);
                                } else {
                                    $set('hide_at', null);
                                }
                            }),
                    ])
                    ->columns(2)
            ]);
    }

    protected static function getCategoryOptions($categories, $prefix = '')
    {
        $options = [];
        foreach ($categories as $category) {
            $options[$category->id] = $prefix . ' ' . $category->title . ' ' . $category->prefix;
            if ($category->children()->count() > 0) {
                $options += self::getCategoryOptions($category->children, $prefix . '——');
            }
        }
        return $options;
    }
}
