<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class MediaManager extends Page
{
    protected string $view = 'filament.pages.media-manager';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-folder-open';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Media';

    protected static ?int $navigationSort = 5;

    public ?array $data = [];
    public array $files = [];

    public function mount(): void
    {
        $this->loadFiles();
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)->schema([
                    FileUpload::make('file')
                        ->label('Upload File')
                        ->required()
                        ->disk('public')
                        ->directory('media')
                        ->maxSize(10240) // 10MB
                ]),
            ])
            ->statePath('data');
    }

    public function loadFiles(): void
    {
        $disk = Storage::disk('public');
        
        if (!$disk->exists('media')) {
            $disk->makeDirectory('media');
        }

        $allFiles = $disk->files('media');
        $this->files = [];

        foreach ($allFiles as $file) {
            $name = basename($file);
            $size = $disk->size($file);
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            
            $type = 'other';
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                $type = 'image';
            } elseif ($extension === 'pdf') {
                $type = 'pdf';
            } elseif (in_array($extension, ['zip', 'rar', 'gz'])) {
                $type = 'archive';
            }

            $this->files[] = [
                'name' => $name,
                'url' => $disk->url($file),
                'size' => $this->formatBytes($size),
                'type' => $type,
                'extension' => $extension,
            ];
        }
    }

    public function save(): void
    {
        Notification::make()
            ->title('File uploaded successfully.')
            ->success()
            ->send();

        $this->form->fill();
        $this->loadFiles();
    }

    public function deleteFile(string $name): void
    {
        $path = 'media/' . $name;
        $disk = Storage::disk('public');

        if ($disk->exists($path)) {
            $disk->delete($path);
            Notification::make()
                ->title('File deleted successfully.')
                ->success()
                ->send();
        }

        $this->loadFiles();
    }

    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
