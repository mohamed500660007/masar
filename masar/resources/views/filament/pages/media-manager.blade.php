<x-filament-panels::page>
    <!-- Upload Section -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Upload New Asset</h2>
        <form wire:submit.prevent="save" class="space-y-4">
            {{ $this->form }}
            <div class="flex justify-end">
                <x-filament::button type="submit">
                    Upload File
                </x-filament::button>
            </div>
        </form>
    </div>

    <!-- Files List Section -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h2 class="text-lg font-bold mb-6 text-gray-900 dark:text-white">Uploaded Assets</h2>

        @if(count($files) === 0)
            <div class="flex flex-col items-center justify-center p-8 border border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V4a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
                <p class="text-sm text-gray-500 dark:text-gray-400">No media assets found. Upload a file above.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($files as $file)
                    <div class="flex flex-col border border-gray-100 dark:border-gray-700 rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-900">
                        <!-- Thumbnail/Preview Area -->
                        <div class="h-32 flex items-center justify-center bg-gray-100 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 relative group">
                            @if($file['type'] === 'image')
                                <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="object-cover w-full h-full">
                            @elseif($file['type'] === 'pdf')
                                <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                            @elseif($file['type'] === 'archive')
                                <svg class="w-12 h-12 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Info Area -->
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="font-semibold text-sm truncate text-gray-900 dark:text-white" title="{{ $file['name'] }}">{{ $file['name'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $file['size'] }}</div>
                            </div>
                            
                            <div class="flex items-center gap-2 mt-4 pt-3 border-t border-gray-100 dark:border-gray-700">
                                <a href="{{ $file['url'] }}" target="_blank" class="flex-1 text-center bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-xs py-1.5 px-3 rounded-lg font-medium hover:bg-primary-100">
                                    Open
                                </a>
                                <button type="button" x-data="{ copied: false }" @click="navigator.clipboard.writeText('{{ $file['url'] }}'); copied = true; setTimeout(() => copied = false, 2000)" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 bg-gray-100 dark:bg-gray-800 p-1.5 rounded-lg">
                                    <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                    <svg x-show="copied" class="w-4 h-4 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                                <button type="button" wire:click="deleteFile('{{ $file['name'] }}')" wire:confirm="Are you sure you want to delete this file?" class="text-danger-600 hover:text-danger-900 bg-danger-50 dark:bg-danger-900/20 p-1.5 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-filament-panels::page>
