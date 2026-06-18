<?php

namespace App\Filament\Resources\Topics\Schemas;

use App\Models\Topic;
use App\Enums\Status;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Str;

class TopicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                            $operation === 'create' ? $set('slug', Str::slug($state)) : null
                        ),
                    TextInput::make('slug')
                        ->required()
                        ->unique(Topic::class, 'slug', ignoreRecord: true)
                        ->maxLength(255),
                ]),
                Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Grid::make(2)->schema([
                    Select::make('subject_id')
                        ->relationship('subject', 'name')
                        ->required()
                        ->searchable()
                        ->preload(),
                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                ]),
                Grid::make(3)->schema([
                    TextInput::make('mdx_path')
                        ->required()
                        ->placeholder('e.g. content/operating-systems/processes.mdx')
                        ->maxLength(255),
                    TextInput::make('reading_time')
                        ->numeric()
                        ->default(0),
                    Select::make('status')
                        ->required()
                        ->options(Status::class)
                        ->default(Status::Draft),
                ]),
                Grid::make(2)->schema([
                    FileUpload::make('cover_image')
                        ->image()
                        ->directory('topics/covers'),
                    DateTimePicker::make('published_at'),
                ]),
                Section::make('Search Engine Optimization (SEO)')
                    ->collapsed()
                    ->schema([
                        TextInput::make('seo_title')
                            ->maxLength(255),
                        Textarea::make('seo_description')
                            ->maxLength(65535),
                    ]),
            ]);
    }
}
