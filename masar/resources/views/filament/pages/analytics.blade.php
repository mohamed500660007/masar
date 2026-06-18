<x-filament-panels::page>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div>
                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Article Views</span>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalViews) }}</h3>
            </div>
            <div class="p-3 bg-primary-50 dark:bg-primary-900/30 rounded-lg text-primary-600 dark:text-primary-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div>
                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">Newsletter Subscribers</span>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($subscribersCount) }}</h3>
            </div>
            <div class="p-3 bg-success-50 dark:bg-success-900/30 rounded-lg text-success-600 dark:text-success-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/></svg>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div>
                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">Content Catalog</span>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                    {{ $articlesCount }} <span class="text-sm font-normal text-gray-400">Articles</span>
                </h3>
                <div class="text-xs text-gray-400 mt-1">
                    {{ $subjectsCount }} Subjects &bull; {{ $topicsCount }} Topics
                </div>
            </div>
            <div class="p-3 bg-warning-50 dark:bg-warning-900/30 rounded-lg text-warning-600 dark:text-warning-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>
    </div>

    <!-- Details Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Most Viewed Articles -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Most Viewed Articles</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700 text-xs font-semibold text-gray-500 dark:text-gray-400">
                            <th class="py-3 pr-4">Article</th>
                            <th class="py-3 px-4 text-right">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                        @forelse($topArticles as $article)
                            <tr>
                                <td class="py-3 pr-4 font-medium text-gray-900 dark:text-white truncate max-w-xs">{{ $article['title'] }}</td>
                                <td class="py-3 px-4 text-right font-bold text-gray-900 dark:text-white">{{ number_format($article['views_count']) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-400 text-xs">No articles view data available yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Subscribers -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Recent Newsletter Signups</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700 text-xs font-semibold text-gray-500 dark:text-gray-400">
                            <th class="py-3 pr-4">Email Address</th>
                            <th class="py-3 pl-4 text-right">Subscribed At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                        @forelse($recentSubscribers as $subscriber)
                            <tr>
                                <td class="py-3 pr-4 font-medium text-gray-900 dark:text-white">{{ $subscriber['email'] }}</td>
                                <td class="py-3 pl-4 text-right text-gray-500 dark:text-gray-400 text-xs">{{ $subscriber['subscribed_at'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-400 text-xs">No subscribers yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
