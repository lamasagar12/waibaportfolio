<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
Auth::requireAuth();
$adminUser = Auth::user();
$currentPage = basename(dirname($_SERVER['PHP_SELF']));
if ($currentPage === 'admin') $currentPage = 'dashboard';
$flashSuccess = flash('success');
$flashError = flash('error');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($adminTitle ?? 'Dashboard') ?> | SG Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{accent:'#F4A933',accentHover:'#FFB84D'}}}}</script>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="icon" href="<?= asset_url('images/profile.png') ?>">
</head>
<body class="sg-admin-body text-white font-sans">
<?php if ($flashSuccess): ?><div class="sg-toast sg-toast-success" id="sg-toast"><?= e($flashSuccess) ?></div><?php endif; ?>
<?php if ($flashError): ?><div class="sg-toast sg-toast-error" id="sg-toast"><?= e($flashError) ?></div><?php endif; ?>

<aside class="sg-admin-sidebar" id="sg-sidebar">
    <div class="p-5 border-b border-white/5">
        <a href="<?= base_url('admin/') ?>" class="flex items-center gap-3">
            <img src="<?= asset_url('images/profile.png') ?>" alt="Admin" class="w-9 h-9 rounded-full ring-2 ring-accent/30">
            <div>
                <div class="font-heading font-bold text-sm">SG Admin</div>
                <div class="text-textMuted text-xs">Content Manager</div>
            </div>
        </a>
    </div>
    <nav class="py-4 space-y-1">
        <?php
        $menu = [
            ['dashboard', 'Dashboard', 'admin/', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>'],
            ['pages', 'Website Pages', 'admin/pages/', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>'],
            ['seo', 'SEO Settings', 'admin/seo/settings.php', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>'],
            ['blogs', 'Blogs', 'admin/blogs/', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3v5h5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12h10"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16h10"></path></svg>'],
            ['blogs-create', 'Add New Blog', 'admin/blogs/create.php', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>'],
            ['categories', 'Categories', 'admin/categories/', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>'],
            ['tags', 'Tags', 'admin/tags/', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>'],
            ['media', 'Media Library', 'admin/media/', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'],
            ['anchors', 'Anchor Text Report', 'admin/anchors/', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>'],
            ['sitemap', 'Sitemap / Robots', 'admin/sitemap/', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>'],
            ['profile', 'Profile', 'admin/profile/', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>'],
        ];

$script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');

foreach ($menu as $item):
    $key = $item[0] ?? '';
    $label = $item[1] ?? 'Menu';
    $url = $item[2] ?? '#';
    $icon = $item[3] ?? '';

    $urlParts = explode('/', trim($url, '/'));
    $section = $urlParts[1] ?? '';

    $active = false;

    if ($key === 'dashboard') {
        $active = str_ends_with($script, '/admin/index.php') || str_ends_with($script, '/admin/');
    } elseif ($key === 'blogs') {
        $active = str_contains($script, '/blogs/') && !str_contains($script, 'create.php');
    } elseif ($key === 'blogs-create') {
        $active = str_contains($script, 'create.php');
    } elseif ($key === 'seo') {
        $active = str_contains($script, '/seo/');
    } elseif (!empty($section)) {
        $active = str_contains($script, '/admin/' . $section . '/');
    }
?>
<a href="<?= base_url($url) ?>" class="sg-admin-nav-item <?= $active ? 'active' : '' ?>">
    <span class="<?= $active ? 'text-accent' : 'text-textMuted' ?> transition-colors"><?= $icon ?></span> <?= e($label) ?>
</a>
<?php endforeach; ?>
        <a href="<?= base_url('admin/logout.php') ?>" class="sg-admin-nav-item text-red-400 hover:text-red-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg> Logout
        </a>
    </nav>
</aside>

<div class="sg-admin-main" id="sg-main">
    <header class="sg-admin-topbar">
        <div class="flex items-center gap-4">
            <button id="sidebar-toggle" class="text-accent text-xl lg:hidden" aria-label="Toggle menu">☰</button>
            <h1 class="font-heading font-bold text-lg"><?= e($adminTitle ?? 'Dashboard') ?></h1>
        </div>
        <div class="relative group">
            <button class="flex items-center gap-2 text-sm">
                <img src="<?= asset_url('images/profile.png') ?>" class="w-8 h-8 rounded-full ring-1 ring-accent/30" alt="">
                <span class="hidden sm:inline"><?= e($adminUser['name']) ?></span>
                <span class="text-textMuted">▾</span>
            </button>
            <div class="absolute right-0 top-full mt-2 w-48 sg-card py-2 hidden group-hover:block z-50">
                <a href="<?= base_url('admin/profile/') ?>" class="block px-4 py-2 text-sm hover:text-accent">Profile</a>
                <a href="<?= base_url() ?>" target="_blank" class="block px-4 py-2 text-sm hover:text-accent">View Site</a>
                <a href="<?= base_url('admin/logout.php') ?>" class="block px-4 py-2 text-sm text-red-400">Logout</a>
            </div>
        </div>
    </header>
    <div class="p-6">
