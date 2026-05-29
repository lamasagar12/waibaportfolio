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
        ['Total Posts', $blogStats['total'], '📝'],
        ['Published', $blogStats['published'], '✅'],
        ['Drafts', $blogStats['draft'], '📋'],
        ['Total Pages', $totalPages, '📄'],
        ['SEO Score', $avgSeo . '%', '🎯'],
        ['Media Files', $mediaCount, '🖼️'],
        ['Anchor Links', $anchorCount, '🔗'],
        ['Internal Links', $internalCount, '↗️'],
    ];
    foreach ($stats as [$label, $val, $icon]): ?>
    <div class="sg-stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-textMuted text-xs uppercase tracking-wide"><?= $label ?></p>
                <p class="text-2xl font-bold text-accent mt-1"><?= $val ?></p>
            </div>
            <span class="text-2xl opacity-50"><?= $icon ?></span>
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
