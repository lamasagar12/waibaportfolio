<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
Auth::requireAuth();
$db = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    if (isset($_POST['robots_txt'])) {
        $db->prepare('UPDATE seo_settings SET robots_txt = ? WHERE id = 1')->execute([$_POST['robots_txt']]);
        flash('success', 'Robots.txt updated.');
    }
    if (!empty($_POST['redirect_source'])) {
        $db->prepare('INSERT INTO redirects (source_url, target_url, redirect_type) VALUES (?,?,?)')->execute([
            trim($_POST['redirect_source']), trim($_POST['redirect_target']), (int)($_POST['redirect_type'] ?? 301)
        ]);
        flash('success', 'Redirect added.');
    }
    if (!empty($_POST['delete_redirect'])) {
        $db->prepare('DELETE FROM redirects WHERE id = ?')->execute([(int)$_POST['delete_redirect']]);
        flash('success', 'Redirect deleted.');
    }
    redirect(base_url('admin/sitemap/'));
}

$settings = SeoService::getGlobalSettings();
$redirects = $db->query('SELECT * FROM redirects ORDER BY created_at DESC')->fetchAll();
$sitemapPreview = SitemapService::generate();

$adminTitle = 'Sitemap & Robots';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="sg-card p-5">
        <h3 class="font-heading font-bold text-accent mb-4">Robots.txt Editor</h3>
        <form method="POST">
            <?= CSRF::field() ?>
            <textarea name="robots_txt" rows="8" class="sg-form-input font-mono text-xs mb-3"><?= e($settings['robots_txt']) ?></textarea>
            <button type="submit" class="sg-btn-primary text-sm">Save Robots.txt</button>
        </form>
        <div class="mt-4 text-xs text-textMuted">
            Live: <a href="<?= base_url('robots.txt') ?>" target="_blank" class="text-accent"><?= base_url('robots.txt') ?></a>
        </div>
    </div>

    <div class="sg-card p-5">
        <h3 class="font-heading font-bold text-accent mb-4">XML Sitemap</h3>
        <p class="text-textSecondary text-sm mb-3">Auto-generated sitemap includes pages, blogs, and images.</p>
        <a href="<?= base_url('sitemap.xml') ?>" target="_blank" class="sg-btn-outline text-sm">View Sitemap</a>
        <pre class="mt-4 bg-black/50 p-3 rounded text-xs text-textMuted overflow-auto max-h-48"><?= e(substr($sitemapPreview, 0, 800)) ?>...</pre>
    </div>

    <div class="lg:col-span-2 sg-card p-5">
        <h3 class="font-heading font-bold text-accent mb-4">301 Redirect Manager</h3>
        <form method="POST" class="flex flex-wrap gap-3 mb-4">
            <?= CSRF::field() ?>
            <input name="redirect_source" placeholder="/old-url" class="sg-form-input max-w-xs" required>
            <input name="redirect_target" placeholder="/new-url" class="sg-form-input max-w-xs" required>
            <select name="redirect_type" class="sg-form-input max-w-[100px]"><option value="301">301</option><option value="302">302</option></select>
            <button type="submit" class="sg-btn-primary text-sm">Add Redirect</button>
        </form>
        <table class="sg-table">
            <thead><tr><th>Source</th><th>Target</th><th>Type</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($redirects as $r): ?>
                <tr>
                    <td class="text-sm"><?= e($r['source_url']) ?></td>
                    <td class="text-sm text-accent"><?= e($r['target_url']) ?></td>
                    <td><?= $r['redirect_type'] ?></td>
                    <td><form method="POST" class="inline" onsubmit="return confirm('Delete?')"><?= CSRF::field() ?><input type="hidden" name="delete_redirect" value="<?= $r['id'] ?>"><button class="text-red-400 text-sm">Delete</button></form></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
