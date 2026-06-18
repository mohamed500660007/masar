<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Topic;
use App\Models\Subject;

Route::get('/preview/topics/{topic:slug}', function (Topic $topic) {
    $subject = $topic->subject;
    $allSubjects = Subject::with('topics')->orderBy('sort_order')->get();
    
    // Find previous and next topics for navigation
    $siblings = $subject->topics()->orderBy('sort_order')->get();
    $currentIndex = $siblings->search(fn ($t) => $t->id === $topic->id);
    
    $prevTopic = $currentIndex > 0 ? $siblings->get($currentIndex - 1) : null;
    $nextTopic = $currentIndex < $siblings->count() - 1 ? $siblings->get($currentIndex + 1) : null;
    
    // Read MDX file if it exists, otherwise use fallback gorgeous template content
    $content = '';
    $mdxFileExists = false;
    $components = [];
    if ($topic->mdx_path && file_exists(base_path($topic->mdx_path))) {
        $content = file_get_contents(base_path($topic->mdx_path));
        $mdxFileExists = true;

        // Parse and extract export const Component = () => { ... } blocks
        preg_match_all('/(export\s+const\s+(\w+)\s*=\s*\((.*?)\)\s*=>\s*\{.*?\r?\n\})/s', $content, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $fullBlock = $match[1];
            $componentName = $match[2];
            // Replace 'export const' with 'const' for client-side evaluation
            $components[$componentName] = str_replace('export const', 'const', $fullBlock);
        }

        // Remove components from markdown content
        $content = preg_replace('/export\s+const\s+\w+\s*=\s*\((.*?)\)\s*=>\s*\{.*?\r?\n\}/s', '', $content);

        // Strip imports (e.g. import { useState } from 'react')
        $content = preg_replace('/^import\s+.*?;?\s*$/m', '', $content);

        // Strip frontmatter
        $content = preg_replace('/^---\r?\n.*?\r?\n---\r?\n/s', '', $content);
    } else {
        $content = "
# {$topic->name}

{$topic->description}

Welcome to the comprehensive developer documentation for **{$topic->name}**. This guide covers the core concepts, implementation details, and architectural trade-offs.

## Introduction

In modern computer science, **{$topic->name}** plays a critical role in structuring systems and optimizing execution patterns. Understanding its underlying mechanics is essential for designing scalable, high-performance applications.

## Key Concepts

Here are the fundamental pillars of this topic:

1. **Abstraction Layer**: How the system represents the data or resource.
2. **Resource Management**: Balancing latency, memory overhead, and compute footprints.
3. **Execution Model**: The lifecycle, state transitions, and concurrency constraints.

### Architecture Diagram

Below is a conceptual flow showing the system layout:

```
[Client Application] ───(API Request)───> [Load Balancer]
                                                 │
                             ┌───────────────────┴───────────────────┐
                             ▼                                       ▼
                     [Worker Node A]                         [Worker Node B]
                            │                                       │
                            ▼                                       ▼
                    [(Local Cache)]                         [(Local Cache)]
```

## Implementation & Code Example

Here is a practical code example illustrating the concepts in action:

```javascript
// Example logic demonstrating {$topic->name} core pattern
class ResourceManager {
  constructor(capacity) {
    this.capacity = capacity;
    this.store = new Map();
  }

  async acquire(key) {
    if (this.store.has(key)) {
      console.log(`Cache Hit for: \${key}`);
      return this.store.get(key);
    }
    
    // Simulate acquisition latency
    const resource = await this.fetchResource(key);
    this.store.set(key, resource);
    return resource;
  }

  fetchResource(key) {
    return new Promise(resolve => setTimeout(() => resolve(`ResourceData_\${key}`), 100));
  }
}
```

## Best Practices & Trade-offs

* **Monitor State Transitions**: Keep latency graphs to observe bottlenecks.
* **Define Invalidation Boundaries**: Ensure caches and indices are updated deterministically.
* **Keep Objects Immutable**: Minimize side-effects during concurrent operations.
";
    }

    // Convert MDX/Markdown content to HTML using Laravel's built-in markdown engine
    $renderedHtml = Illuminate\Support\Str::markdown($content);

    return view('preview.topic', compact('topic', 'subject', 'allSubjects', 'prevTopic', 'nextTopic', 'renderedHtml', 'mdxFileExists', 'components'));
})->name('topics.preview');
