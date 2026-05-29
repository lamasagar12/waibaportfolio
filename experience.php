<?php
$page_key = 'experience';
require_once 'includes/header.php';
require_once 'includes/page-helpers.php';
sg_page_hero('Work <span>History</span>', 'Professional journey as an SEO Specialist.');
$experience = [
    [
        'title' => 'Search Engine Optimization Analyst',
        'company' => 'Hotstone Innovations',
        'type' => 'Full-time',
        'location' => 'Remote / Hybrid',
        'period' => 'Dec 2025 – Feb 2026',
        'desc' => [
            'Analyzed website SEO performance and identified opportunities to improve search visibility.',
            'Conducted keyword research, competitor analysis, and on-page optimization for client websites.',
            'Worked on technical checks, content improvements, tracking review, and performance reporting.',
            'Supported SEO strategy planning based on ranking, traffic, and visibility data.'
        ]
    ],
    [
        'title' => 'Search Engine Optimization Specialist',
        'company' => 'Digital Terai',
        'location' => 'Kathmandu',
        'period' => 'Jan 2025 – Present',
        'desc' => [
            'Managed SEO campaigns for national and international clients across multiple industries.',
            'Improved organic visibility for travel, real estate, construction, and service-based websites.',
            'Conducted technical audits, on-page SEO improvements, content planning, and backlink strategies.',
            'Created SEO and SMM proposals tailored to client goals, budgets, and growth opportunities.',
            'Supported client communication, task planning, reporting, and project execution workflows.'
        ]
    ],
    [
        'title' => 'SEO Intern',
        'company' => 'Digital Terai',
        'location' => 'Kathmandu',
        'period' => 'Sep 2024 – Dec 2024',
        'desc' => [
            'Assisted with off-page SEO and link-building strategies for multiple client projects.',
            'Researched competitor backlinks, outreach opportunities, and citation sources.',
            'Optimized blogs, service pages, and metadata to support keyword ranking improvements.'
        ]
    ]
];
?>
<section class="px-6 pb-20">
    <div class="max-w-4xl mx-auto relative">
        <!-- Vertical Line -->
        <div class="absolute left-0 md:left-1/2 top-0 bottom-0 w-px bg-white/5 md:-translate-x-px"></div>
        
        <div class="space-y-12">
            <?php foreach ($experience as $index => $exp): 
                $isEven = $index % 2 === 0;
            ?>
            <div class="relative flex flex-col md:flex-row items-start md:items-center">
                <!-- Timeline Dot -->
                <div class="absolute left-0 md:left-1/2 w-4 h-4 rounded-full bg-accent border-4 border-primary shadow-glow md:-translate-x-2 z-10"></div>
                
                <div class="w-full md:w-1/2 <?= $isEven ? 'md:pr-12 md:text-right' : 'md:pl-12 md:ml-auto' ?> pl-8 md:pl-0">
                    <div class="sg-card p-6 animate-on-scroll hover:border-accent/40 group">
                        <div class="inline-block px-3 py-1 rounded-full bg-accent/10 text-accent text-[10px] font-mono uppercase tracking-widest mb-4">
                            <?= $exp['period'] ?>
                        </div>
                        <h3 class="font-heading text-2xl mb-1 text-textPrimary group-hover:text-accent transition-colors"><?= $exp['title'] ?></h3>
                        <div class="text-accentLight font-medium mb-4 flex flex-col md:flex-row md:items-center <?= $isEven ? 'md:justify-end' : '' ?> gap-2">
                            <span><?= $exp['company'] ?></span>
                            <?php if (isset($exp['type'])): ?><span class="hidden md:inline text-white/20">•</span><span class="text-textMuted text-xs"><?= $exp['type'] ?></span><?php endif; ?>
                            <span class="hidden md:inline text-white/20">•</span>
                            <span class="text-textMuted text-xs italic"><?= $exp['location'] ?></span>
                        </div>
                        <ul class="space-y-3 text-sm text-textMuted text-left">
                            <?php foreach ($exp['desc'] as $item): ?>
                            <li class="flex items-start gap-3">
                                <span class="text-accent mt-1 text-[10px]">✦</span>
                                <span><?= $item ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
