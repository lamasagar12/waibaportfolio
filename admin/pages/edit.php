<?php
$adminTitle = 'Edit Page SEO';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/seo-preview.php';

$key = $_GET['key'] ?? '';
$page = SeoService::getPageSeo($key);
if (!$page) { flash('error', 'Page not found.'); redirect(base_url('admin/pages/')); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    $data = [
        'page_title' => trim($_POST['page_title'] ?? ''),
        'meta_title' => trim($_POST['meta_title'] ?? ''),
        'meta_description' => trim($_POST['meta_description'] ?? ''),
        'focus_keyword' => trim($_POST['focus_keyword'] ?? ''),
        'secondary_keywords' => trim($_POST['secondary_keywords'] ?? ''),
        'slug' => slugify($_POST['slug'] ?? ''),
        'canonical_url' => trim($_POST['canonical_url'] ?? ''),
        'og_title' => trim($_POST['og_title'] ?? ''),
        'og_description' => trim($_POST['og_description'] ?? ''),
        'twitter_title' => trim($_POST['twitter_title'] ?? ''),
        'twitter_description' => trim($_POST['twitter_description'] ?? ''),
        'robots_index' => $_POST['robots_index'] ?? 'index',
        'robots_follow' => $_POST['robots_follow'] ?? 'follow',
        'schema_type' => $_POST['schema_type'] ?? 'WebPage',
        'custom_schema' => $_POST['custom_schema'] ?? null,
        'seo_notes' => trim($_POST['seo_notes'] ?? ''),
    ];
    if (!empty($_FILES['og_image']['name'])) {
        $up = ImageService::upload($_FILES['og_image']);
        if ($up) $data['og_image'] = $up['file_url'];
    } elseif (!empty($_POST['og_image_current'])) {
        $data['og_image'] = $_POST['og_image_current'];
    }
    SeoService::updatePageSeo($key, $data);
    flash('success', 'Page SEO updated.');
    redirect(base_url('admin/pages/edit.php?key=' . urlencode($key)));
}
$p = $page;
?>

<form method="POST" enctype="multipart/form-data" class="space-y-6">
    <?= CSRF::field() ?>
    <div class="sg-card p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="sg-form-label">Page Title</label><input name="page_title" id="page_title" value="<?= e($p['page_title']) ?>" class="sg-form-input"></div>
        <div><label class="sg-form-label">Meta Title</label><input name="meta_title" id="page_meta_title" value="<?= e($p['meta_title']) ?>" class="sg-form-input"><span data-char-counter="#page_meta_title" data-min="30" data-max="60" class="sg-char-counter text-xs"></span></div>
        <div class="md:col-span-2"><label class="sg-form-label">Meta Description</label><textarea name="meta_description" id="page_meta_description" rows="3" class="sg-form-input"><?= e($p['meta_description']) ?></textarea><span data-char-counter="#page_meta_description" data-min="120" data-max="160" class="sg-char-counter text-xs"></span></div>
        <div><label class="sg-form-label">Focus Keyword</label><input name="focus_keyword" value="<?= e($p['focus_keyword']) ?>" class="sg-form-input"></div>
        <div><label class="sg-form-label">Secondary Keywords</label><input name="secondary_keywords" value="<?= e($p['secondary_keywords']) ?>" class="sg-form-input"></div>
        <div><label class="sg-form-label">Slug</label><input name="slug" id="page_slug" value="<?= e($p['slug']) ?>" class="sg-form-input"></div>
        <div><label class="sg-form-label">Canonical URL</label><input name="canonical_url" value="<?= e($p['canonical_url']) ?>" class="sg-form-input"></div>
        <div><label class="sg-form-label">Schema Type</label><select name="schema_type" class="sg-form-input"><option <?= $p['schema_type']==='WebPage'?'selected':'' ?>>WebPage</option><option <?= $p['schema_type']==='AboutPage'?'selected':'' ?>>AboutPage</option><option <?= $p['schema_type']==='ContactPage'?'selected':'' ?>>ContactPage</option><option <?= $p['schema_type']==='CollectionPage'?'selected':'' ?>>CollectionPage</option></select></div>
        <div class="flex gap-4">
            <div class="flex-1"><label class="sg-form-label">Index</label><select name="robots_index" class="sg-form-input"><option value="index" <?= $p['robots_index']==='index'?'selected':'' ?>>index</option><option value="noindex" <?= $p['robots_index']==='noindex'?'selected':'' ?>>noindex</option></select></div>
            <div class="flex-1"><label class="sg-form-label">Follow</label><select name="robots_follow" class="sg-form-input"><option value="follow" <?= $p['robots_follow']==='follow'?'selected':'' ?>>follow</option><option value="nofollow" <?= $p['robots_follow']==='nofollow'?'selected':'' ?>>nofollow</option></select></div>
        </div>
        <div><label class="sg-form-label">OG Title</label><input name="og_title" value="<?= e($p['og_title']) ?>" class="sg-form-input"></div>
        <div><label class="sg-form-label">OG Image</label><input type="file" name="og_image" accept="image/*" class="sg-form-input"><input type="hidden" name="og_image_current" value="<?= e($p['og_image']) ?>"></div>
        <div class="md:col-span-2"><label class="sg-form-label">Custom Schema JSON-LD</label><textarea name="custom_schema" rows="4" class="sg-form-input font-mono text-xs"><?= e($p['custom_schema']) ?></textarea></div>
        <div class="md:col-span-2"><label class="sg-form-label">SEO Notes</label><textarea name="seo_notes" rows="2" class="sg-form-input"><?= e($p['seo_notes']) ?></textarea></div>
    </div>
    <?php sg_seo_preview('page', base_url()); ?>
    <div class="flex gap-3">
        <button type="submit" class="sg-btn-primary">Save Page SEO</button>
        <a href="<?= base_url('admin/pages/') ?>" class="sg-btn-outline">Back</a>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
