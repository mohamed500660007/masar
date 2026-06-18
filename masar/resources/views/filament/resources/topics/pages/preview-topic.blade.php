<x-filament-panels::page>
    <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-950 dark:ring-white/10">
        <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-800 pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $record->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $record->description }}</p>
            </div>
            <div>
                <a href="{{ route('filament.admin.resources.topics.index') }}" class="fi-btn fi-btn-size-md relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-gray bg-white text-gray-700 hover:bg-gray-50 dark:bg-white/5 dark:text-gray-200 dark:hover:bg-white/10 ring-1 ring-gray-950/10 dark:ring-white/20 px-3 py-2 text-sm inline-grid">
                    Back to Topics
                </a>
            </div>
        </div>

        <!-- Rendered MDX Content -->
        <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
            {!! $renderedHtml !!}
        </div>
    </div>

    <style>
        .prose h1, .prose h2, .prose h3, .prose h4 {
            color: inherit;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        .prose h1 { font-size: 1.8rem; border-bottom: 1px solid rgba(148, 163, 184, 0.2); padding-bottom: 8px; }
        .prose h2 { font-size: 1.4rem; }
        .prose h3 { font-size: 1.15rem; }
        .prose p { margin-bottom: 1.25rem; }
        .prose ul, .prose ol { margin-bottom: 1.25rem; padding-left: 1.5rem; }
        .prose li { margin-bottom: 0.5rem; }
        .prose code { font-family: monospace; background-color: rgba(120, 120, 120, 0.1); padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
        .prose pre { background-color: #020617; border: 1px solid rgba(148, 163, 184, 0.1); border-radius: 8px; padding: 16px; overflow-x: auto; margin: 1.5rem 0; }
        .prose pre code { background-color: transparent; padding: 0; }
        .prose blockquote { border-left: 4px solid #6366f1; padding-left: 16px; font-style: italic; margin: 1.5rem 0; background-color: rgba(99, 102, 241, 0.05); padding: 12px 16px; border-radius: 0 8px 8px 0; }
    </style>

    @if(!empty($components))
        <!-- React & Babel CDNs -->
        <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
        <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
        <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

        <script type="text/babel">
            // Inject hooks into the Babel namespace scope
            const { useState, useEffect, useRef } = React;

            // Define component functions
            @foreach($components as $name => $code)
                {!! $code !!}
            @endforeach

            // Map component names to their definitions
            const componentsMap = {
                @foreach($components as $name => $code)
                    '{{ strtolower($name) }}': {{ $name }},
                @endforeach
            };

            // Render each component into their div placeholder with data-mdx-component attribute
            document.querySelectorAll('[data-mdx-component]').forEach(el => {
                const componentName = el.getAttribute('data-mdx-component');
                const Component = componentsMap[componentName];
                if (Component) {
                    const root = ReactDOM.createRoot(el);
                    root.render(<Component />);
                }
            });
        </script>
    @endif
</x-filament-panels::page>
