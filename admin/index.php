<?php
$adminTitle = 'Dashboard';
require_once __DIR__ . '/includes/header.php';

try {
    $db = get_db();
    $blogStats = BlogModel::stats();
    $totalPages = (int)$db->query('SELECT COUNT(*) FROM page_seo')->fetchColumn();
    $avgSeo = (int)$db->query('SELECT COALESCE(AVG(seo_score),0) FROM blog_posts')->fetchColumn();
    $mediaCount = (int)$db->query('SELECT COUNT(*) FROM media_files')->fetchColumn();
    $anchorCount = (int)$db->query('SELECT COUNT(*) FROM anchor_links')->fetchColumn();
    $internalCount = (int)$db->query("SELECT COUNT(*) FROM anchor_links WHERE link_type = 'internal'")->fetchColumn();
    $recentBlogs = $db->query('SELECT title, status, updated_at, seo_score FROM blog_posts ORDER BY updated_at DESC LIMIT 5')->fetchAll();
    $recentSeo = $db->query('SELECT * FROM seo_activity_log ORDER BY created_at DESC LIMIT 5')->fetchAll();
} catch (Exception $e) {
    $blogStats = ['total'=>0,'published'=>0,'draft'=>0,'scheduled'=>0];
    $totalPages = 0; $avgSeo = 0; $mediaCount = 0; $anchorCount = 0; $internalCount = 0;
    $recentBlogs = []; $recentSeo = [];
    echo '<div class="sg-card p-4 mb-6 border-accent/30"><p class="text-accent">Database not installed. <a href="' . base_url('install.php') . '" class="underline">Run installer</a></p></div>';
}
?>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <?php
    $stats = [
        ['Total Posts', $blogStats['total'], '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>'],
        ['Published', $blogStats['published'], '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'],
        ['Drafts', $blogStats['draft'], '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>'],
        ['Total Pages', $totalPages, '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>'],
        ['SEO Score', $avgSeo . '%', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>'],
        ['Media Files', $mediaCount, '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'],
        ['Anchor Links', $anchorCount, '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>'],
        ['Internal Links', $internalCount, '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>'],
    ];
    foreach ($stats as [$label, $val, $icon]): ?>
    <div class="sg-stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-textMuted text-xs uppercase tracking-wide"><?= $label ?></p>
                <p class="text-2xl font-bold text-accent mt-1"><?= $val ?></p>
            </div>
            <span class="text-accent opacity-20"><?= $icon ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="flex flex-wrap gap-3 mb-8">
    <a href="<?= base_url('admin/blogs/create.php') ?>" class="sg-btn-primary text-sm">+ Add New Blog</a>
    <a href="<?= base_url('admin/seo/settings.php') ?>" class="sg-btn-outline text-sm">Update SEO Settings</a>
    <a href="<?= base_url('admin/pages/') ?>" class="sg-btn-outline text-sm">Manage Pages</a>
    <a href="<?= base_url('admin/media/') ?>" class="sg-btn-outline text-sm">Upload Media</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="sg-card p-5">
        <h3 class="font-heading font-bold mb-4">Recent Blog Updates</h3>
        <?php if (empty($recentBlogs)): ?>
        <p class="text-textMuted text-sm">No blog posts yet.</p>
        <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($recentBlogs as $b): ?>
            <div class="flex items-center justify-between text-sm border-b border-white/5 pb-2">
                <span><?= e($b['title']) ?></span>
                <div class="flex items-center gap-2">
                    <span class="sg-badge <?= status_badge($b['status']) ?>"><?= e($b['status']) ?></span>
                    <span class="sg-badge <?= seo_score_badge_class($b['seo_score']) ?>"><?= $b['seo_score'] ?>%</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="sg-card p-5">
        <h3 class="font-heading font-bold mb-4">Recent SEO Changes</h3>
        <?php if (empty($recentSeo)): ?>
        <p class="text-textMuted text-sm">No SEO activity yet.</p>
        <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($recentSeo as $s): ?>
            <div class="text-sm border-b border-white/5 pb-2">
                <span class="text-accent"><?= e($s['action']) ?></span>
                <span class="text-textMuted"> — <?= e($s['description']) ?></span>
                <div class="text-textMuted text-xs mt-1"><?= format_date($s['created_at'], 'M d, Y H:i') ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
