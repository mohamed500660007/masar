<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Models\Article;
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

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                            $operation === 'create' ? $set('slug', Str::slug($state)) : null
                        ),
                    TextInput::make('slug')
                        ->required()
                        ->unique(Article::class, 'slug', ignoreRecord: true)
                        ->maxLength(255),
                ]),
                Textarea::make('excerpt')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload(),
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
                        ->directory('articles/covers'),
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
