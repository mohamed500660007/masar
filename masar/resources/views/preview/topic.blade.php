@php
    $returnUrl = request()->query('return_url');
    if (empty($returnUrl) || str_contains($returnUrl, 'livewire') || str_contains($returnUrl, '/update')) {
        $returnUrl = '/admin/topics';
    }
@endphp
<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->seo_title ?? $topic->name . ' - Masar Docs' }}</title>
    <meta name="description" content="{{ $topic->seo_description ?? $topic->description }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-main: #0B0F19;
            --bg-sidebar: #0F1322;
            --bg-card: #151B30;
            --border-color: #1E293B;
            --text-primary: #F8FAFC;
            --text-secondary: #94A3B8;
            --text-muted: #64748B;
            --primary: #6366F1;
            --primary-hover: #4F46E5;
            --primary-glow: rgba(99, 102, 241, 0.15);
            --accent: #10B981;
            --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --font-mono: 'JetBrains Mono', SFMono-Regular, Consolas, monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-secondary);
            font-family: var(--font-sans);
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Layout Structure */
        .app-container {
            display: flex;
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        /* Top Navbar */
        .top-navbar {
            height: 64px;
            background-color: var(--bg-sidebar);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 10;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: 0 0 15px var(--primary-glow);
        }

        .logo-text {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -0.5px;
        }

        .logo-badge {
            background-color: var(--border-color);
            color: var(--text-secondary);
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .back-btn {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            background-color: var(--border-color);
            transform: translateY(-1px);
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 280px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            flex-shrink: 0;
            padding: 24px 16px;
        }

        .subject-group {
            margin-bottom: 24px;
        }

        .subject-header {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-primary);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            padding-left: 8px;
        }

        .subject-icon {
            color: var(--primary);
            width: 16px;
            height: 16px;
        }

        .topic-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .topic-item a {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 6px;
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .topic-item a:hover {
            color: var(--text-primary);
            background-color: rgba(255, 255, 255, 0.03);
            padding-left: 16px;
        }

        .topic-item.active a {
            color: var(--text-primary);
            background: linear-gradient(90deg, var(--primary-glow), transparent);
            border-left: 3px solid var(--primary);
            font-weight: 600;
            padding-left: 12px;
        }

        /* Main Scrollable Content Area */
        .main-content {
            flex: 1;
            overflow-y: auto;
            background-color: var(--bg-main);
            min-height: 0;
        }

        .content-body {
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
            padding: 48px 24px 64px 24px;
            flex: 1;
        }

        /* Breadcrumbs */
        .breadcrumbs {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 24px;
            font-weight: 500;
        }

        .breadcrumbs a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumbs a:hover {
            color: var(--text-primary);
        }

        .breadcrumbs-sep {
            color: var(--border-color);
        }

        /* Header Metadata */
        .doc-header {
            margin-bottom: 32px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 24px;
        }

        .doc-title {
            color: var(--text-primary);
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .metadata-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .meta-icon {
            width: 14px;
            height: 14px;
            stroke-width: 2;
        }

        .badge-draft {
            background-color: rgba(245, 158, 11, 0.1);
            color: #F59E0B;
            border: 1px solid rgba(245, 158, 11, 0.2);
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-published {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10B981;
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Rendered Markdown/HTML Content */
        .prose {
            line-height: 1.7;
            font-size: 1rem;
            color: var(--text-secondary);
        }

        .prose h1, .prose h2, .prose h3, .prose h4 {
            color: var(--text-primary);
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .prose h1 {
            font-size: 1.8rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px;
        }

        .prose h2 {
            font-size: 1.4rem;
        }

        .prose h3 {
            font-size: 1.15rem;
        }

        .prose p {
            margin-bottom: 1.25rem;
        }

        .prose ul, .prose ol {
            margin-bottom: 1.25rem;
            padding-left: 1.5rem;
        }

        .prose li {
            margin-bottom: 0.5rem;
        }

        .prose a {
            color: var(--primary);
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .prose a:hover {
            border-color: var(--primary);
        }

        .prose code {
            font-family: var(--font-mono);
            background-color: rgba(255, 255, 255, 0.05);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85em;
            color: #E2E8F0;
        }

        .prose pre {
            background-color: var(--bg-sidebar);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 16px;
            overflow-x: auto;
            margin: 1.5rem 0;
            font-family: var(--font-mono);
            font-size: 0.9rem;
        }

        .prose pre code {
            background-color: transparent;
            padding: 0;
            border-radius: 0;
            color: #F8FAFC;
        }

        .prose blockquote {
            border-left: 4px solid var(--primary);
            padding-left: 16px;
            font-style: italic;
            color: var(--text-primary);
            margin: 1.5rem 0;
            background-color: rgba(99, 102, 241, 0.03);
            padding: 12px 16px;
            border-radius: 0 8px 8px 0;
        }

        /* Post Navigation */
        .post-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 48px;
            border-top: 1px solid var(--border-color);
            padding-top: 32px;
        }

        .nav-card {
            flex: 1;
            background-color: var(--bg-sidebar);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .nav-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .nav-card.prev {
            align-items: flex-start;
        }

        .nav-card.next {
            align-items: flex-end;
            text-align: right;
        }

        .nav-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .nav-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Right Table of Contents Sidebar */
        .right-sidebar {
            width: 260px;
            padding: 48px 24px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            flex-shrink: 0;
            overflow-y: auto;
            border-left: 1px solid var(--border-color);
        }

        @media (max-width: 1100px) {
            .right-sidebar {
                display: none;
            }
        }

        .toc-title {
            color: var(--text-primary);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .toc-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toc-item {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .toc-item a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .toc-item a:hover {
            color: var(--text-primary);
        }

        .toc-item.sub {
            padding-left: 12px;
            color: var(--text-muted);
        }

        /* Info boxes */
        .info-card {
            background-color: var(--bg-sidebar);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 16px;
            font-size: 0.8rem;
        }

        .info-card-title {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-card-text {
            color: var(--text-secondary);
            line-height: 1.5;
        }
    </style>
</head>
<body class="h-full">

    <!-- Top Navbar -->
    <header class="top-navbar">
        <a href="#" class="logo-container">
            <div class="logo-icon">M</div>
            <span class="logo-text">Masar Docs</span>
            <span class="logo-badge">Preview</span>
        </a>
        <div class="navbar-actions">
            <a href="{{ $returnUrl }}" class="back-btn">
                <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Admin
            </a>
        </div>
    </header>

    <!-- App Main Container -->
    <div class="app-container">
        
        <!-- Left Sidebar Navigation -->
        <aside class="sidebar">
                    <ul class="topic-list">
                        @foreach($allSubjects as $subj)
                            <div class="subject-group">
                                <div class="subject-header">
                                    <svg class="subject-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span>{{ $subj->name }}</span>
                                </div>
                                <ul class="topic-list">
                                    @foreach($subj->topics as $t)
                                        <li class="topic-item {{ $t->id === $topic->id ? 'active' : '' }}">
                                            <a href="{{ route('topics.preview', ['topic' => $t->slug]) }}?return_url={{ urlencode($returnUrl) }}">
                                                {{ $t->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </ul>
        </aside>

        <!-- Central Document View -->
        <main class="main-content">
            <article class="content-body">
                
                <!-- Breadcrumbs -->
                <nav class="breadcrumbs">
                    <a href="#">Docs</a>
                    <span class="breadcrumbs-sep">/</span>
                    <a href="#">{{ $subject->name }}</a>
                    <span class="breadcrumbs-sep">/</span>
                    <span style="color: var(--text-primary)">{{ $topic->name }}</span>
                </nav>

                <!-- Document Header -->
                <header class="doc-header">
                    <h1 class="doc-title">{{ $topic->name }}</h1>
                    
                    <div class="metadata-row">
                        <div class="meta-item">
                            <span class="badge-{{ $topic->status->value === 'published' ? 'published' : 'draft' }}">
                                {{ $topic->status->getLabel() }}
                            </span>
                        </div>
                        
                        <div class="meta-item">
                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/></svg>
                            <span>{{ $topic->reading_time }} min read</span>
                        </div>

                        <div class="meta-item">
                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>{{ number_format($topic->views_count) }} views</span>
                        </div>

                        @if($topic->published_at)
                            <div class="meta-item">
                                <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Published {{ $topic->published_at->format('M d, Y') }}</span>
                            </div>
                        @endif
                    </div>
                </header>

                <!-- Document Body (Markdown Rendered) -->
                <div class="prose">
                    {!! $renderedHtml !!}
                </div>

                <!-- Footer Navigation -->
                <footer class="post-navigation">
                    @if($prevTopic)
                        <a href="{{ route('topics.preview', ['topic' => $prevTopic->slug]) }}?return_url={{ urlencode($returnUrl) }}" class="nav-card prev">
                            <span class="nav-label">Previous Topic</span>
                            <span class="nav-title">{{ $prevTopic->name }}</span>
                        </a>
                    @else
                        <div style="flex: 1"></div>
                    @endif

                    @if($nextTopic)
                        <a href="{{ route('topics.preview', ['topic' => $nextTopic->slug]) }}?return_url={{ urlencode($returnUrl) }}" class="nav-card next">
                            <span class="nav-label">Next Topic</span>
                            <span class="nav-title">{{ $nextTopic->name }}</span>
                        </a>
                    @else
                        <div style="flex: 1"></div>
                    @endif
                </footer>

            </article>
        </main>

        <!-- Right TOC Sidebar -->
        <aside class="right-sidebar">
            <div>
                <h4 class="toc-title">On This Page</h4>
                <ul class="toc-list">
                    <li class="toc-item"><a href="#introduction">Introduction</a></li>
                    <li class="toc-item"><a href="#key-concepts">Key Concepts</a></li>
                    <li class="toc-item sub"><a href="#architecture-diagram">Architecture Diagram</a></li>
                    <li class="toc-item"><a href="#implementation--code-example">Implementation & Code</a></li>
                    <li class="toc-item"><a href="#best-practices--trade-offs">Best Practices</a></li>
                </ul>
            </div>

            <div class="info-card">
                <div class="info-card-title">
                    <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Contribute</span>
                </div>
                <div class="info-card-text">
                    This documentation page is powered by MDX. You can edit this file in your IDE at:
                    <div style="margin-top: 8px; font-family: var(--font-mono); color: var(--primary); word-break: break-all;">
                        {{ $topic->mdx_path ?? 'content/' . $subject->slug . '/' . $topic->slug . '.mdx' }}
                    </div>
                </div>
            </div>
        </aside>

    </div>

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

        // Map tags to component definitions
        const componentsMap = {
            @foreach($components as $name => $code)
                '{{ strtolower($name) }}': {{ $name }},
            @endforeach
        };

        // Render each component into their respective DOM tag containers
        Object.entries(componentsMap).forEach(([tagName, Component]) => {
            const elements = document.getElementsByTagName(tagName);
            for (const el of Array.from(elements)) {
                el.style.display = 'block';
                const root = ReactDOM.createRoot(el);
                root.render(<Component />);
            }
        });
    </script>
@endif
</body>
</html>
