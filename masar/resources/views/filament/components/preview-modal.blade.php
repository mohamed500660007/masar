<div class="space-y-4 text-gray-700 dark:text-gray-300">
    @if($type === 'article')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Title</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $record->title }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Slug</span>
                <span class="text-sm font-mono text-gray-600 dark:text-gray-400">{{ $record->slug }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Subject</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $record->subject?->name ?? 'None' }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Topic</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $record->topic?->name ?? 'None' }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">MDX File Path</span>
                <span class="text-sm font-mono text-primary-600 dark:text-primary-400">{{ $record->mdx_path }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Reading Time</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $record->reading_time }} min</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Status</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $record->status->getColor() }}-50 text-{{ $record->status->getColor() }}-700 dark:bg-{{ $record->status->getColor() }}-900/30 dark:text-{{ $record->status->getColor() }}-400">
                    {{ $record->status->getLabel() }}
                </span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Published At</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $record->published_at?->format('M d, Y H:i') ?? 'Not Published' }}</span>
            </div>
        </div>
        @if($record->excerpt)
            <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-3">
                <span class="text-xs font-semibold text-gray-400 block mb-1">Excerpt</span>
                <p class="text-sm text-gray-600 dark:text-gray-400 italic">"{{ $record->excerpt }}"</p>
            </div>
        @endif
        @if($record->seo_title || $record->seo_description)
            <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-3 bg-gray-50 dark:bg-gray-900 p-3 rounded-lg">
                <span class="text-xs font-semibold text-gray-500 block mb-2 font-bold">SEO Configurations</span>
                @if($record->seo_title)
                    <div class="mb-2">
                        <span class="text-xs text-gray-400 block">SEO Title</span>
                        <span class="text-xs text-gray-700 dark:text-gray-300 font-medium">{{ $record->seo_title }}</span>
                    </div>
                @endif
                @if($record->seo_description)
                    <div>
                        <span class="text-xs text-gray-400 block">SEO Description</span>
                        <span class="text-xs text-gray-700 dark:text-gray-300">{{ $record->seo_description }}</span>
                    </div>
                @endif
            </div>
        @endif
    @elseif($type === 'course')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Title</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $record->title }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Slug</span>
                <span class="text-sm font-mono text-gray-600 dark:text-gray-400">{{ $record->slug }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Subject</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $record->subject?->name ?? 'None' }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Difficulty</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $record->difficulty->getColor() }}-50 text-{{ $record->difficulty->getColor() }}-700 dark:bg-{{ $record->difficulty->getColor() }}-900/30 dark:text-{{ $record->difficulty->getColor() }}-400">
                    {{ $record->difficulty->getLabel() }}
                </span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">MDX Directory</span>
                <span class="text-sm font-mono text-primary-600 dark:text-primary-400">{{ $record->mdx_directory }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Estimated Duration</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $record->estimated_duration }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Status</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $record->status->getColor() }}-50 text-{{ $record->status->getColor() }}-700 dark:bg-{{ $record->status->getColor() }}-900/30 dark:text-{{ $record->status->getColor() }}-400">
                    {{ $record->status->getLabel() }}
                </span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 block">Published At</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $record->published_at?->format('M d, Y H:i') ?? 'Not Published' }}</span>
            </div>
        </div>
        @if($record->description)
            <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-3">
                <span class="text-xs font-semibold text-gray-400 block mb-1">Description</span>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $record->description }}</p>
            </div>
        @endif
    @endif
</div>
