<?php

namespace App\Filament\Resources\Subjects\RelationManagers;

use App\Enums\Status;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;

class TopicsRelationManager extends RelationManager
{
    protected static string $relationship = 'topics';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                            $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255),
                ]),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Grid::make(3)->schema([
                    Forms\Components\TextInput::make('mdx_path')
                        ->required()
                        ->placeholder('e.g. content/operating-systems/processes.mdx')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('reading_time')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Select::make('status')
                        ->required()
                        ->options(Status::class)
                        ->default(Status::Draft),
                ]),
                Grid::make(2)->schema([
                    Forms\Components\FileUpload::make('cover_image')
                        ->image()
                        ->directory('topics/covers'),
                    Forms\Components\DateTimePicker::make('published_at'),
                ]),
                Section::make('Search Engine Optimization (SEO)')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('seo_description')
                            ->maxLength(65535),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reading_time')
                    ->suffix(' min')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => route('topics.preview', [
                        'topic' => $record->slug, 
                        'return_url' => str_contains(request()->fullUrl(), 'livewire') 
                            ? route('filament.admin.resources.subjects.edit', ['record' => $record->subject_id]) 
                            : request()->fullUrl()
                    ]))
                    ->openUrlInNewTab(),
                Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn ($record) => $record->status === Status::Published)
                    ->action(fn ($record) => $record->update([
                        'status' => Status::Published,
                        'published_at' => now(),
                    ]))
                    ->requiresConfirmation(),
                Action::make('unpublish')
                    ->label('Unpublish')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->hidden(fn ($record) => $record->status === Status::Draft)
                    ->action(fn ($record) => $record->update([
                        'status' => Status::Draft,
                        'published_at' => null,
                    ]))
                    ->requiresConfirmation(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    BulkAction::make('publish_selected')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update([
                            'status' => Status::Published,
                            'published_at' => now(),
                        ]))
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}
