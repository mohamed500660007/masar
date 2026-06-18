<?php

namespace App\Filament\Pages;

use App\Models\Subject;
use App\Models\Topic;
use App\Models\Article;
use App\Models\Subscriber;
use Filament\Pages\Page;

class Analytics extends Page
{
    protected string $view = 'filament.pages.analytics';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Analytics';

    protected static ?int $navigationSort = 3;

    public int $subjectsCount = 0;
    public int $topicsCount = 0;
    public int $articlesCount = 0;
    public int $subscribersCount = 0;
    public int $totalViews = 0;
    public array $topArticles = [];
    public array $recentSubscribers = [];

    public function mount(): void
    {
        $this->subjectsCount = Subject::count();
        $this->topicsCount = Topic::count();
        $this->articlesCount = Article::count();
        $this->subscribersCount = Subscriber::count();
        $this->totalViews = (int) Article::sum('views_count');

        $this->topArticles = Article::orderByDesc('views_count')
            ->limit(5)
            ->get()
            ->map(fn ($article) => [
                'title' => $article->title,
                'views_count' => $article->views_count,
                'status' => $article->status->getLabel(),
            ])
            ->toArray();

        $this->recentSubscribers = Subscriber::orderByDesc('subscribed_at')
            ->limit(5)
            ->get()
            ->map(fn ($sub) => [
                'email' => $sub->email,
                'subscribed_at' => $sub->subscribed_at->format('M d, Y H:i'),
            ])
            ->toArray();
    }
}
