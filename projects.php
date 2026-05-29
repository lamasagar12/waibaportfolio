<?php
$page_key = 'projects';
require_once 'includes/header.php';
require_once 'includes/page-helpers.php';
sg_page_hero('Featured <span>Projects</span>', 'Strategic SEO campaigns and digital growth case studies.');
$projects = [
    [
        'title' => 'Nepal Moto Tours',
        'category' => 'Travel Website SEO',
        'desc' => 'Strengthened search presence through structured off-page SEO for a Nepal-based travel and motorbike tours company.',
        'tags' => ['Local Citations', 'Guest Posting', 'Web 2.0', 'Backlink Monitoring'],
        'link' => 'https://nepalmototours.com'
    ],
    [
        'title' => 'Asian Concreto',
        'category' => 'Construction Materials SEO',
        'desc' => 'Built an SEO foundation for a B2B construction materials supplier through audit, keyword planning, and optimization roadmap.',
        'tags' => ['SEO Strategy', 'Technical SEO', 'Keyword Research', 'On-Page SEO'],
        'link' => 'https://asianconcreto.com'
    ],
    [
        'title' => 'Yalla Jet Ski',
        'category' => 'Dubai Water Sports SEO',
        'desc' => 'Handled SEO and local branding strategy for a Dubai water sports business, covering technical, local, and off-page SEO.',
        'tags' => ['Keyword Research', 'Meta Tags', 'Schema', 'GBP Setup'],
        'link' => 'https://yallajetski.com'
    ],
    [
        'title' => 'Jadan Construction Group',
        'category' => 'Construction SEO',
        'desc' => 'Improved online presence for a construction firm through niche-relevant link building, content direction, and local optimization.',
        'tags' => ['Guest Posting', 'Anchor Text', 'Local Listings', 'Niche Backlinks'],
        'link' => 'https://jadanconstructiongroup.com'
    ],
    [
        'title' => 'A One Jetski Dubai',
        'category' => 'Tourism & Water Sports SEO',
        'desc' => 'Worked on local visibility, content optimization, GBP direction, and CRO improvements for high-intent jet ski tour keywords.',
        'tags' => ['Local SEO', 'Tour SEO', 'GBP Optimization', 'CRO'],
        'link' => 'https://aonejetski.com'
    ],
    [
        'title' => '888 Realty',
        'category' => 'Real Estate SEO',
        'desc' => 'Created a local-first SEO strategy for a Vancouver real estate brand focused on visibility, authority, and organic leads.',
        'tags' => ['Real Estate SEO', 'Local SEO', 'Keyword Mapping', 'SEO Proposal'],
        'link' => 'https://888realty.ca'
    ],
    [
        'title' => 'Furious Fleet',
        'category' => 'Luxury Car Rental SEO',
        'desc' => 'Developed a premium digital strategy for luxury car rental and concierge positioning, landing pages, and SEO content planning.',
        'tags' => ['Luxury SEO', 'Brand Strategy', 'Landing Page SEO', 'UX Planning'],
        'link' => 'https://furiousfleet.com'
    ],
    [
        'title' => '360 Castle',
        'category' => 'Real Estate & Local SEO',
        'desc' => 'Worked on real estate digital growth planning, website structure, local SEO direction, GBP setup, and content strategy.',
        'tags' => ['Real Estate SEO', 'GBP Setup', 'Website Strategy', 'Brand Positioning'],
        'link' => 'https://360castle.com'
    ]
];
?>
<section class="px-6 pb-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($projects as $project): ?>
        <div class="sg-card p-0 overflow-hidden group animate-on-scroll border-t-2 border-t-transparent hover:border-t-accent transition-all duration-500">
            <div class="p-8 flex flex-col h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-mono uppercase tracking-widest text-accent font-bold"><?= $project['category'] ?></span>
                    <a href="<?= $project['link'] ?>" target="_blank" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300">↗</a>
                </div>
                <h3 class="font-heading text-3xl mb-4 group-hover:text-accent transition-colors"><?= $project['title'] ?></h3>
                <p class="text-textMuted text-sm mb-8 leading-relaxed"><?= $project['desc'] ?></p>
                
                <div class="flex flex-wrap gap-2 mt-auto">
                    <?php foreach ($project['tags'] as $tag): ?>
                    <span class="px-2 py-1 rounded bg-accent/5 border border-accent/10 text-[10px] text-accent/70 font-mono">
                        <?= $tag ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
