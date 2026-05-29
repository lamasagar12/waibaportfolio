<?php
$page_key = 'certifications';
require_once 'includes/header.php';
require_once 'includes/page-helpers.php';
sg_page_hero('Professional <span>Credentials</span>', 'Certified expertise in SEO and digital strategy.');
$certs = [
    [
        'title' => 'Content Marketing Essentials for SEO and AI Search',
        'issuer' => 'Semrush',
        'date' => 'Issued Apr 2026 · Expires Apr 2027',
        'icon' => '📄'
    ],
    [
        'title' => '5 Day SEO Challenge',
        'issuer' => 'Orka Socials',
        'date' => 'Issued Sep 2024',
        'icon' => '🔥'
    ],
    [
        'title' => 'SEO Course',
        'issuer' => 'Rambabu Thapa',
        'date' => 'Issued 2024',
        'icon' => '🎓'
    ],
    [
        'title' => 'SEO II',
        'issuer' => 'HubSpot Academy',
        'date' => 'Issued Aug 2024 · Expires Sep 2026',
        'id' => '87b5992649904405bf8c3c5a7c97f2d4',
        'icon' => '🧡'
    ],
    [
        'title' => 'SEO',
        'issuer' => 'HubSpot Academy',
        'date' => 'Issued Aug 2024 · Expired Sep 2025',
        'id' => 'a9e6c87a43a742fa9b91fc920e2fe8df',
        'icon' => '📊'
    ],
    [
        'title' => 'Digital Marketing',
        'issuer' => 'HubSpot Academy',
        'date' => 'Issued Aug 2024 · Expired Sep 2025',
        'id' => '88537570ffa84216be1ab883c1d2f9e5',
        'icon' => '📈'
    ],
    [
        'title' => 'LinkedIn Marketing Strategy',
        'issuer' => 'LinkedIn',
        'date' => 'Issued Jul 2024 · Expires Jul 2026',
        'id' => 'k7cm7a68vubq',
        'icon' => '🔗'
    ]
];
?>
<section class="px-6 pb-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($certs as $cert): ?>
        <div class="sg-card p-8 animate-on-scroll flex flex-col items-center text-center group hover:border-accent/40 transition-all duration-500">
            <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center text-3xl mb-6 group-hover:bg-accent/10 transition-colors">
                <?= $cert['icon'] ?>
            </div>
            <h3 class="font-heading text-2xl mb-2 group-hover:text-accent transition-colors"><?= $cert['title'] ?></h3>
            <div class="text-accentLight font-medium text-sm mb-1"><?= $cert['issuer'] ?></div>
            <div class="text-textMuted text-[10px] font-mono uppercase tracking-widest mb-4"><?= $cert['date'] ?></div>
            <?php if (isset($cert['id'])): ?>
            <div class="mt-auto pt-4 border-t border-white/5 w-full">
                <span class="text-[10px] font-mono text-white/20 uppercase tracking-tighter">ID: <?= $cert['id'] ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
