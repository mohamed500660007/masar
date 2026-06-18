<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Article;
use App\Models\Tag;
use App\Models\Subscriber;
use App\Models\SiteSetting;
use App\Enums\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Create Site Settings
        SiteSetting::firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Masar Computer Science Docs',
                'site_description' => 'A structured learning platform for Computer Science concepts, subjects, and engineering fundamentals.',
                'logo' => null,
                'social_links' => [
                    'github' => 'https://github.com',
                    'twitter' => 'https://twitter.com',
                    'youtube' => 'https://youtube.com',
                ],
                'seo_defaults' => [
                    'title' => 'Masar Computer Science Documentation',
                    'description' => 'Master OS, Networking, Databases, System Design, and more with our structured docs.',
                ],
            ]
        );

        // 3. Create Tags
        $tagsData = [
            'Performance', 'Security', 'Scalability', 'Architecture',
            'Fundamentals', 'Advanced', 'Case Study', 'Best Practices',
            'Laravel', 'PHP', 'Docker', 'Git', 'Redis'
        ];
        $tags = [];
        foreach ($tagsData as $tagName) {
            $tags[] = Tag::firstOrCreate([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }

        // 4. Create Subjects and Topics (Topics are the MDX content pages here)
        $subjectsData = [
            'Operating Systems' => [
                'icon' => 'heroicon-o-cpu-chip',
                'topics' => [
                    'Processes & Threads' => [
                        'description' => 'An in-depth look at how operating systems represent and manage process state using Process Control Blocks (PCB) and execute context switches.',
                        'mdx_path' => 'content/operating-systems/processes/pcb.mdx',
                        'reading_time' => 8,
                    ],
                    'Memory Management' => [
                        'description' => 'How virtual-to-physical address mapping works, page tables, paging mechanisms, and handling page faults.',
                        'mdx_path' => 'content/operating-systems/memory/paging.mdx',
                        'reading_time' => 15,
                    ],
                    'File Systems' => [
                        'description' => 'Exploring how Unix-like operating systems structure files, index nodes (inodes), and directory layouts.',
                        'mdx_path' => 'content/operating-systems/files/inodes.mdx',
                        'reading_time' => 10,
                    ]
                ]
            ],
            'Networking' => [
                'icon' => 'heroicon-o-globe-alt',
                'topics' => [
                    'TCP/IP Protocol Suite' => [
                        'description' => 'Detailed breakdown of TCP connections, three-way handshakes, UDP protocols, and stateful communication.',
                        'mdx_path' => 'content/networking/tcp-ip/udp-vs-tcp.mdx',
                        'reading_time' => 6,
                    ],
                    'Routing Algorithms' => [
                        'description' => 'Comparing Link-State vs Distance-Vector routing, convergence speeds, OSPF, and RIP protocols.',
                        'mdx_path' => 'content/networking/routing/algorithms.mdx',
                        'reading_time' => 12,
                    ],
                    'DNS & HTTP' => [
                        'description' => 'Follow the path of a DNS query from roots to authoritative servers, and request/response lifecycles of HTTP/3.',
                        'mdx_path' => 'content/networking/dns-http/dns-query.mdx',
                        'reading_time' => 9,
                    ]
                ]
            ],
            'Databases' => [
                'icon' => 'heroicon-o-circle-stack',
                'topics' => [
                    'Relational Algebra & SQL' => [
                        'description' => 'Relational schemas, query plan evaluation, database normalization forms from 1NF up to Boyce-Codd Normal Form.',
                        'mdx_path' => 'content/databases/sql/normalization.mdx',
                        'reading_time' => 11,
                    ],
                    'Indexing & B-Trees' => [
                        'description' => 'Understanding structural properties of B-Tree indexes, leaf splits, and performance profiles of primary vs secondary indexes.',
                        'mdx_path' => 'content/databases/indexing/b-trees.mdx',
                        'reading_time' => 13,
                    ],
                    'Transactions & ACID' => [
                        'description' => 'ACID guarantees, serializability, transaction isolation levels (repeatable reads, phantom reads), and lock mechanics.',
                        'mdx_path' => 'content/databases/transactions/isolation-levels.mdx',
                        'reading_time' => 15,
                    ]
                ]
            ],
            'Data Structures & Algorithms' => [
                'icon' => 'heroicon-o-square-3-stack-3d',
                'topics' => [
                    'Trees & Graphs' => [
                        'description' => 'Master insertion, deletion, and search algorithms within balanced binary search trees, and traverse graphs via BFS/DFS.',
                        'mdx_path' => 'content/dsa/trees/bst-operations.mdx',
                        'reading_time' => 10,
                    ],
                    'Dynamic Programming' => [
                        'description' => 'Memoization vs tabulation strategies, optimal substructure, overlapping subproblems, and solving classic knapsack/LCS problems.',
                        'mdx_path' => 'content/dsa/dp/memoization-tabulation.mdx',
                        'reading_time' => 12,
                    ]
                ]
            ],
            'System Design' => [
                'icon' => 'heroicon-o-cloud',
                'topics' => [
                    'Load Balancing & Scaling' => [
                        'description' => 'Proving horizontal vs vertical scaling limits, load balancers, DNS routing, and consistent hashing algorithms.',
                        'mdx_path' => 'content/system-design/scaling/consistent-hashing.mdx',
                        'reading_time' => 11,
                    ],
                    'Caching Strategies' => [
                        'description' => 'Determining caching policies (LRU, LFU), invalidation patterns, and write-through vs write-back database pipelines.',
                        'mdx_path' => 'content/system-design/caching/strategies.mdx',
                        'reading_time' => 9,
                    ]
                ]
            ],
        ];

        $subjectOrder = 1;
        foreach ($subjectsData as $subjectName => $subjectInfo) {
            $subject = Subject::firstOrCreate(
                ['name' => $subjectName],
                [
                    'slug' => Str::slug($subjectName),
                    'description' => "Comprehensive reference documentation covering {$subjectName} core concepts.",
                    'icon' => $subjectInfo['icon'],
                    'sort_order' => $subjectOrder++,
                ]
            );

            $topicOrder = 1;
            foreach ($subjectInfo['topics'] as $topicName => $topicMeta) {
                $status = rand(1, 10) > 2 ? Status::Published : Status::Draft;
                $publishedAt = $status === Status::Published ? now()->subDays(rand(0, 90)) : null;

                Topic::firstOrCreate(
                    [
                        'name' => $topicName,
                        'subject_id' => $subject->id,
                    ],
                    [
                        'slug' => Str::slug($topicName),
                        'description' => $topicMeta['description'],
                        'mdx_path' => $topicMeta['mdx_path'],
                        'reading_time' => $topicMeta['reading_time'],
                        'views_count' => rand(200, 15000),
                        'status' => $status,
                        'published_at' => $publishedAt,
                        'seo_title' => "Mastering {$topicName} | Masar Docs",
                        'seo_description' => Str::limit($topicMeta['description'], 150),
                        'sort_order' => $topicOrder++,
                    ]
                );
            }
        }

        // 5. Create Standalone General Software Articles
        $articlesData = [
            [
                'title' => 'Advanced Caching Patterns in Laravel',
                'excerpt' => 'Exploring multi-level caches, database query caching, tag-based invalidations, and custom drivers in Laravel applications.',
                'mdx_path' => 'content/articles/laravel-caching.mdx',
                'reading_time' => 7,
                'tags' => ['Laravel', 'Performance', 'Best Practices', 'Redis']
            ],
            [
                'title' => 'Understanding PHP Garbage Collection mechanisms',
                'excerpt' => 'An inside-out look at how PHP handles reference counting, cycle detection, and memory reclamation in long-running processes.',
                'mdx_path' => 'content/articles/php-garbage-collection.mdx',
                'reading_time' => 9,
                'tags' => ['PHP', 'Fundamentals', 'Advanced', 'Performance']
            ],
            [
                'title' => 'Git Rebase vs Merge: Workflows Compared',
                'excerpt' => 'When to rewrite history with rebase, when to keep trace logs with merge, and resolving conflicts safely.',
                'mdx_path' => 'content/articles/git-rebase-vs-merge.mdx',
                'reading_time' => 5,
                'tags' => ['Git', 'Best Practices', 'Fundamentals']
            ],
            [
                'title' => 'Docker Bridge vs Host Networking Modes',
                'excerpt' => 'Deep dive into standard container networking modes, custom virtual bridges, and resolving port allocation friction.',
                'mdx_path' => 'content/articles/docker-networking.mdx',
                'reading_time' => 11,
                'tags' => ['Docker', 'Architecture', 'Security']
            ],
            [
                'title' => 'Distributed Locking Patterns using Redis',
                'excerpt' => 'How to implement the Redlock algorithm to coordinate resource isolation across elastic horizontal nodes.',
                'mdx_path' => 'content/articles/redis-locks.mdx',
                'reading_time' => 8,
                'tags' => ['Redis', 'Scalability', 'Advanced']
            ],
        ];

        foreach ($articlesData as $art) {
            $status = rand(1, 10) > 2 ? Status::Published : Status::Draft;
            $publishedAt = $status === Status::Published ? now()->subDays(rand(0, 60)) : null;

            $article = Article::firstOrCreate(
                ['slug' => Str::slug($art['title'])],
                [
                    'title' => $art['title'],
                    'excerpt' => $art['excerpt'],
                    'mdx_path' => $art['mdx_path'],
                    'reading_time' => $art['reading_time'],
                    'views_count' => rand(100, 8000),
                    'status' => $status,
                    'published_at' => $publishedAt,
                    'seo_title' => "{$art['title']} | Masar",
                    'seo_description' => Str::limit($art['excerpt'], 150),
                ]
            );

            // Sync tags
            $articleTags = [];
            foreach ($art['tags'] as $tagName) {
                $foundTag = Tag::where('name', $tagName)->first();
                if ($foundTag) {
                    $articleTags[] = $foundTag->id;
                }
            }
            $article->tags()->sync($articleTags);
        }

        // 6. Create Subscribers
        $subscribersEmails = [
            'alex.dev@gmail.com', 'john.doe@yahoo.com', 'maria.s@outlook.com',
            'clara_coder@github.com', 'sam.smith@apple.com', 'sophie.w@protonmail.com',
            'eduardo.dsa@university.edu', 'taylor.laravel@medium.com', 'dan.net@cisco.com',
            'lisa.sysdesign@amazon.com', 'kevin.os@linux.org', 'emma.db@oracle.com'
        ];

        foreach ($subscribersEmails as $email) {
            Subscriber::firstOrCreate(
                ['email' => $email],
                [
                    'subscribed_at' => now()->subDays(rand(1, 90)),
                ]
            );
        }
    }
}
