<?php
require_once __DIR__ . '/bootstrap.php';

$page_key = $page_key ?? 'home';
$pageSeo = SeoService::getPageSeo($page_key);
$meta = SeoService::buildMeta([
    'title' => $page_title ?? null,
    'description' => $page_description ?? null,
], $pageSeo);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php render_seo_head($meta); ?>
    <link rel="icon" type="image/png" href="<?= asset_url('images/profile.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#080808',
                        accent: '#f59e0b',
                        accentLight: '#fbbf24',
                        accentDark: '#d97706',
                        textPrimary: '#f5f5f5',
                        textMuted: '#9ca3af',
                        border: 'rgba(255,255,255,0.08)',
                        borderAmber: 'rgba(245,158,11,0.32)',
                    },
                    boxShadow: {
                        glow: '0 0 30px rgba(245,158,11,0.25)',
                        glowSm: '0 0 15px rgba(245,158,11,0.15)',
                        amber: '0 0 20px rgba(245,158,11,0.3)',
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        heading: ['Bebas Neue', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="<?= asset_url('css/style.css') ?>">
</head>
<body class="bg-primary text-textPrimary font-sans antialiased sg-body">
<?php if (!empty($meta['global']['gtm_id'])): ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= e($meta['global']['gtm_id']) ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php endif; ?>
<div class="sg-particles fixed inset-0 pointer-events-none z-0"></div>

<header class="sg-header fixed top-0 left-0 right-0 z-50 sg-glass border-b border-white/5">
    <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="<?= base_url() ?>" class="flex items-center gap-3 group">
            <img src="<?= asset_url('images/profile.png') ?>" alt="Sagar Waiba" class="w-10 h-10 rounded-full ring-2 ring-accent/30 group-hover:ring-accent transition">
            <span class="font-heading font-bold text-lg">Sagar <span class="text-accent">Waiba</span></span>
        </a>
        <div class="hidden md:flex items-center gap-8">
            <?php
            $nav = [
                ['Home', base_url(), 'home'],
                ['About', base_url('about.php'), 'about'],
                ['Skills', base_url('skills.php'), 'skills'],
                ['Experience', base_url('experience.php'), 'experience'],
                ['Projects', base_url('projects.php'), 'projects'],
                ['Blog', base_url('blog.php'), 'blog'],
                ['Contact', base_url('contact.php'), 'contact'],
            ];
            foreach ($nav as [$label, $url, $key]):
                $active = ($page_key ?? '') === $key ? 'text-accent' : 'text-textSecondary hover:text-accent';
            ?>
            <a href="<?= $url ?>" class="<?= $active ?> transition font-medium text-sm"><?= $label ?></a>
            <?php endforeach; ?>
        </div>
        <a href="<?= base_url('contact.php') ?>" class="hidden md:inline-flex sg-btn-primary text-sm">Let's Talk</a>
        <button id="mobile-menu-btn" class="md:hidden text-accent text-2xl" aria-label="Menu">☰</button>
    </nav>
    <div id="mobile-menu" class="hidden md:hidden px-6 pb-4 space-y-3 border-t border-white/5">
        <?php foreach ($nav as [$label, $url]): ?>
        <a href="<?= $url ?>" class="block text-textSecondary hover:text-accent py-2"><?= $label ?></a>
        <?php endforeach; ?>
    </div>
</header>
<main class="relative z-10 pt-24">
