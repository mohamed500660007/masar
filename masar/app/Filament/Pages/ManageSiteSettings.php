<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Notifications\Notification;
use Filament\Actions\Action;

class ManageSiteSettings extends Page
{
    protected string $view = 'filament.pages.manage-site-settings';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?int $navigationSort = 4;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::firstOrCreate([
            'id' => 1
        ], [
            'site_name' => 'CS Docs',
            'site_description' => 'Computer Science Documentation Platform',
        ]);
        
        $this->form->fill($settings->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('site_description')
                    ->maxLength(65535),
                FileUpload::make('logo')
                    ->image()
                    ->directory('settings'),
                Section::make('Social Links')
                    ->schema([
                        TextInput::make('social_links.github')
                            ->url()
                            ->label('GitHub URL'),
                        TextInput::make('social_links.twitter')
                            ->url()
                            ->label('Twitter URL'),
                        TextInput::make('social_links.youtube')
                            ->url()
                            ->label('YouTube URL'),
                    ])->columns(3),
                Section::make('SEO Defaults')
                    ->schema([
                        TextInput::make('seo_defaults.title_template')
                            ->placeholder('e.g. %s | CS Docs')
                            ->label('Title Template'),
                        Textarea::make('seo_defaults.meta_description')
                            ->label('Meta Description'),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save settings')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $settings = SiteSetting::first();
        $settings->update($this->form->getState());

        Notification::make()
            ->title('Settings saved successfully.')
            ->success()
            ->send();
    }
}
