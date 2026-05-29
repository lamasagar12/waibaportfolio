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
            ['dashboard', 'Dashboard', 'admin/', '📊'],
            ['pages', 'Website Pages', 'admin/pages/', '📄'],
            ['seo', 'SEO Settings', 'admin/seo/settings.php', '🔍'],
            ['blogs', 'Blogs', 'admin/blogs/', '📝'],
            ['blogs-create', 'Add New Blog', 'admin/blogs/create.php', '➕'],
            ['categories', 'Categories', 'admin/categories/', '📁'],
            ['tags', 'Tags', 'admin/tags/', '🏷️'],
            ['media', 'Media Library', 'admin/media/', '🖼️'],
            ['anchors', 'Anchor Text Report', 'admin/anchors/', '🔗'],
            ['sitemap', 'Sitemap / Robots', 'admin/sitemap/', '🗺️'],
            ['profile', 'Profile', 'admin/profile/', '👤'],
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
    <span><?= e($icon) ?></span> <?= e($label) ?>
</a>
<?php endforeach; ?>
        <a href="<?= base_url('admin/logout.php') ?>" class="sg-admin-nav-item text-red-400 hover:text-red-300">
            <span>🚪</span> Logout
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
