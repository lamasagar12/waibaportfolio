<?php
$page_key = 'skills';
require_once 'includes/header.php';
require_once 'includes/page-helpers.php';
sg_page_hero('Skills & <span>Expertise</span>', 'Technical proficiency and strategic SEO competencies.');
$skill_groups = [
    'SEO Tools' => [
        'icon' => '🛠️',
        'items' => ['GA4', 'GSC', 'GTM', 'Microsoft Clarity', 'Semrush', 'Ahrefs', 'Screaming Frog', 'Looker Studio']
    ],
    'SEO Expertise' => [
        'icon' => '🎯',
        'items' => ['Keyword Research', 'On-Page SEO', 'Technical SEO Audit', 'Content Optimization', 'URL Structuring', 'Schema Markup']
    ],
    'Off-Page SEO' => [
        'icon' => '🔗',
        'items' => ['Link Building', 'Guest Posting', 'Web 2.0 Articles', 'Local Citations', 'Brand Submissions', 'Anchor Text Optimization']
    ],
    'Local SEO' => [
        'icon' => '📍',
        'items' => ['Google Business Profile', 'Local Citation Building', 'Map Visibility', 'Regional SEO']
    ],
    'Digital Marketing' => [
        'icon' => '📈',
        'items' => ['SEO Reporting', 'Proposal Writing', 'Content Planning', 'WordPress Management', 'CRO Recommendations']
    ],
    'Languages' => [
        'icon' => '🌐',
        'items' => ['English', 'Nepali', 'Hindi', 'Tamang']
    ]
];
?>
<section class="px-6 pb-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($skill_groups as $group => $data): ?>
        <div class="sg-card p-8 animate-on-scroll flex flex-col h-full border-t-2 border-t-transparent hover:border-t-accent transition-all duration-500">
            <div class="flex items-center gap-4 mb-6">
                <div class="text-3xl"><?= $data['icon'] ?></div>
                <h3 class="font-heading text-2xl tracking-wide"><?= $group ?></h3>
            </div>
            <div class="flex flex-wrap gap-2 mt-auto">
                <?php foreach ($data['items'] as $item): ?>
                <span class="px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-textMuted text-xs font-mono transition-all duration-300 hover:bg-accent/10 hover:border-accent/30 hover:text-accent cursor-default">
                    <?= $item ?>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
