<?php
$adminTitle = 'Website Pages SEO';
require_once __DIR__ . '/../includes/header.php';

try {
    $pages = SeoService::getAllPages();
} catch (Exception $e) {
    echo '<div class="sg-card p-4"><a href="' . base_url('install.php') . '" class="text-accent">Run installer</a></div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}
?>

<div class="sg-card overflow-hidden">
    <table class="sg-table">
        <thead>
            <tr>
                <th>Page</th>
                <th>Meta Title</th>
                <th>Focus Keyword</th>
                <th>Slug</th>
                <th>Robots</th>
                <th>Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $p): ?>
            <tr>
                <td class="font-medium"><?= e($p['page_title']) ?></td>
                <td class="text-textSecondary max-w-xs truncate"><?= e($p['meta_title']) ?></td>
                <td><span class="sg-badge sg-badge-muted"><?= e($p['focus_keyword']) ?></span></td>
                <td class="text-textMuted text-xs"><?= e($p['slug']) ?></td>
                <td class="text-xs"><?= e($p['robots_index']) ?>, <?= e($p['robots_follow']) ?></td>
                <td class="text-textMuted text-xs"><?= format_date($p['updated_at']) ?></td>
                <td><a href="<?= base_url('admin/pages/edit.php?key=' . urlencode($p['page_key'])) ?>" class="text-accent text-sm hover:underline">Edit SEO</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
