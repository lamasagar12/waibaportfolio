<?php
$page_key = 'skills';
require_once 'includes/header.php';
require_once 'includes/page-helpers.php';
sg_page_hero('Skills & <span>Expertise</span>', 'Technical proficiency and strategic SEO competencies.');
$skill_groups = [
    'SEO Tools' => [
        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>',
        'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800',
        'items' => ['GA4', 'GSC', 'GTM', 'Microsoft Clarity', 'Semrush', 'Ahrefs', 'Screaming Frog', 'Looker Studio']
    ],
    'SEO Expertise' => [
        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>',
        'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800',
        'items' => ['Keyword Research', 'On-Page SEO', 'Technical SEO Audit', 'Content Optimization', 'URL Structuring', 'Schema Markup']
    ],
    'Off-Page SEO' => [
        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>',
        'image' => 'https://images.unsplash.com/photo-1557838923-2985c318be48?auto=format&fit=crop&q=80&w=800',
        'items' => ['Link Building', 'Guest Posting', 'Web 2.0 Articles', 'Local Citations', 'Brand Submissions', 'Anchor Text Optimization']
    ],
    'Local SEO' => [
        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
        'image' => 'https://images.unsplash.com/photo-1526628953301-3e589a6a8b74?auto=format&fit=crop&q=80&w=800',
        'items' => ['Google Business Profile', 'Local Citation Building', 'Map Visibility', 'Regional SEO']
    ],
    'Digital Marketing' => [
        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
        'image' => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?auto=format&fit=crop&q=80&w=800',
        'items' => ['SEO Reporting', 'Proposal Writing', 'Content Planning', 'WordPress Management', 'CRO Recommendations']
    ]
];
?>
<section class="px-6 pb-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($skill_groups as $group => $data): ?>
        <div class="sg-card p-0 overflow-hidden animate-on-scroll flex flex-col h-full border-t-2 border-t-transparent hover:border-t-accent transition-all duration-500">
            <div class="relative h-48 overflow-hidden group/img">
                <img src="<?= $data['image'] ?>" alt="<?= $group ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover/img:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
                <div class="absolute bottom-4 left-6 text-accent"><?= $data['icon'] ?></div>
            </div>
            <div class="p-8 pt-6">
                <div class="flex items-center gap-4 mb-6">
                    <h3 class="font-heading text-2xl tracking-wide"><?= $group ?></h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($data['items'] as $item): ?>
                    <span class="px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-textMuted text-xs font-mono transition-all duration-300 hover:bg-accent/10 hover:border-accent/30 hover:text-accent cursor-default">
                        <?= $item ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
