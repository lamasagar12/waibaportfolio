<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
Auth::requireAuth();

try {
    $settings = SeoService::getGlobalSettings();
} catch (Exception $e) {
    $adminTitle = 'Global SEO Settings';
    require_once __DIR__ . '/../includes/header.php';
    echo '<div class="sg-card p-4"><a href="' . base_url('install.php') . '" class="text-accent">Run installer first</a></div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    $data = [
        'website_title' => trim($_POST['website_title'] ?? ''),
        'website_tagline' => trim($_POST['website_tagline'] ?? ''),
        'default_meta_title' => trim($_POST['default_meta_title'] ?? ''),
        'default_meta_description' => trim($_POST['default_meta_description'] ?? ''),
        'default_meta_keywords' => trim($_POST['default_meta_keywords'] ?? ''),
        'site_author' => trim($_POST['site_author'] ?? ''),
        'canonical_url' => trim($_POST['canonical_url'] ?? ''),
        'robots_index' => $_POST['robots_index'] ?? 'index',
        'robots_follow' => $_POST['robots_follow'] ?? 'follow',
        'og_title' => trim($_POST['og_title'] ?? ''),
        'og_description' => trim($_POST['og_description'] ?? ''),
        'twitter_title' => trim($_POST['twitter_title'] ?? ''),
        'twitter_description' => trim($_POST['twitter_description'] ?? ''),
        'twitter_card_type' => $_POST['twitter_card_type'] ?? 'summary_large_image',
        'ga4_id' => trim($_POST['ga4_id'] ?? ''),
        'gtm_id' => trim($_POST['gtm_id'] ?? ''),
        'gsc_verification' => trim($_POST['gsc_verification'] ?? ''),
        'bing_verification' => trim($_POST['bing_verification'] ?? ''),
        'facebook_pixel_id' => trim($_POST['facebook_pixel_id'] ?? ''),
        'custom_head_scripts' => $_POST['custom_head_scripts'] ?? '',
        'custom_body_scripts' => $_POST['custom_body_scripts'] ?? '',
        'person_schema' => $_POST['person_schema'] ?? null,
        'organization_schema' => $_POST['organization_schema'] ?? null,
        'website_schema' => $_POST['website_schema'] ?? null,
        'breadcrumb_schema' => !empty($_POST['breadcrumb_schema']) ? 1 : 0,
        'article_schema' => !empty($_POST['article_schema']) ? 1 : 0,
        'local_business_schema' => $_POST['local_business_schema'] ?? null,
        'sitemap_enabled' => !empty($_POST['sitemap_enabled']) ? 1 : 0,
        'robots_txt' => $_POST['robots_txt'] ?? '',
    ];

    if (!empty($_FILES['og_image']['name'])) {
        $uploaded = ImageService::upload($_FILES['og_image']);
        if ($uploaded) $data['og_image'] = $uploaded['file_url'];
    } elseif (!empty($_POST['og_image_current'])) {
        $data['og_image'] = $_POST['og_image_current'];
    }

    if (!empty($_FILES['twitter_image']['name'])) {
        $uploaded = ImageService::upload($_FILES['twitter_image']);
        if ($uploaded) $data['twitter_image'] = $uploaded['file_url'];
    } elseif (!empty($_POST['twitter_image_current'])) {
        $data['twitter_image'] = $_POST['twitter_image_current'];
    }

    SeoService::updateGlobalSettings($data);
    flash('success', 'SEO settings saved successfully.');
    redirect(base_url('admin/seo/settings.php'));
}
$s = $settings;

$adminTitle = 'Global SEO Settings';
require_once __DIR__ . '/../includes/header.php';
?>

<form method="POST" enctype="multipart/form-data" class="space-y-8">
    <?= CSRF::field() ?>

    <div class="sg-card p-6">
        <h3 class="font-heading font-bold text-accent mb-4">Basic SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="sg-form-label">Website Title</label><input name="website_title" value="<?= e($s['website_title']) ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">Website Tagline</label><input name="website_tagline" value="<?= e($s['website_tagline']) ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">Default Meta Title</label><input name="default_meta_title" id="global_meta_title" value="<?= e($s['default_meta_title']) ?>" class="sg-form-input"><span data-char-counter="#global_meta_title" data-min="30" data-max="60" class="sg-char-counter text-xs"></span></div>
            <div><label class="sg-form-label">Site Author</label><input name="site_author" value="<?= e($s['site_author']) ?>" class="sg-form-input"></div>
            <div class="md:col-span-2"><label class="sg-form-label">Default Meta Description</label><textarea name="default_meta_description" id="global_meta_description" rows="3" class="sg-form-input"><?= e($s['default_meta_description']) ?></textarea><span data-char-counter="#global_meta_description" data-min="120" data-max="160" class="sg-char-counter text-xs"></span></div>
            <div class="md:col-span-2"><label class="sg-form-label">Default Meta Keywords</label><input name="default_meta_keywords" value="<?= e($s['default_meta_keywords']) ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">Canonical URL</label><input name="canonical_url" value="<?= e($s['canonical_url']) ?>" class="sg-form-input"></div>
            <div class="flex gap-4">
                <div class="flex-1"><label class="sg-form-label">Robots Index</label><select name="robots_index" class="sg-form-input"><option value="index" <?= $s['robots_index']==='index'?'selected':'' ?>>index</option><option value="noindex" <?= $s['robots_index']==='noindex'?'selected':'' ?>>noindex</option></select></div>
                <div class="flex-1"><label class="sg-form-label">Robots Follow</label><select name="robots_follow" class="sg-form-input"><option value="follow" <?= $s['robots_follow']==='follow'?'selected':'' ?>>follow</option><option value="nofollow" <?= $s['robots_follow']==='nofollow'?'selected':'' ?>>nofollow</option></select></div>
            </div>
        </div>
    </div>

    <div class="sg-card p-6">
        <h3 class="font-heading font-bold text-accent mb-4">Open Graph / Social</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="sg-form-label">OG Title</label><input name="og_title" value="<?= e($s['og_title']) ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">OG Image</label><input type="file" name="og_image" accept="image/*" class="sg-form-input"><input type="hidden" name="og_image_current" value="<?= e($s['og_image']) ?>"></div>
            <div class="md:col-span-2"><label class="sg-form-label">OG Description</label><textarea name="og_description" rows="2" class="sg-form-input"><?= e($s['og_description']) ?></textarea></div>
            <div><label class="sg-form-label">Twitter Title</label><input name="twitter_title" value="<?= e($s['twitter_title']) ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">Twitter Image</label><input type="file" name="twitter_image" accept="image/*" class="sg-form-input"><input type="hidden" name="twitter_image_current" value="<?= e($s['twitter_image']) ?>"></div>
            <div class="md:col-span-2"><label class="sg-form-label">Twitter Description</label><textarea name="twitter_description" rows="2" class="sg-form-input"><?= e($s['twitter_description']) ?></textarea></div>
        </div>
    </div>

    <div class="sg-card p-6">
        <h3 class="font-heading font-bold text-accent mb-4">Technical SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="sg-form-label">GA4 ID</label><input name="ga4_id" value="<?= e($s['ga4_id']) ?>" class="sg-form-input" placeholder="G-XXXXXXXX"></div>
            <div><label class="sg-form-label">GTM ID</label><input name="gtm_id" value="<?= e($s['gtm_id']) ?>" class="sg-form-input" placeholder="GTM-XXXXXXX"></div>
            <div><label class="sg-form-label">Google Search Console</label><input name="gsc_verification" value="<?= e($s['gsc_verification']) ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">Bing Webmaster</label><input name="bing_verification" value="<?= e($s['bing_verification']) ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">Facebook Pixel ID</label><input name="facebook_pixel_id" value="<?= e($s['facebook_pixel_id']) ?>" class="sg-form-input"></div>
            <div class="md:col-span-2"><label class="sg-form-label">Custom Head Scripts</label><textarea name="custom_head_scripts" rows="3" class="sg-form-input font-mono text-xs"><?= e($s['custom_head_scripts']) ?></textarea></div>
            <div class="md:col-span-2"><label class="sg-form-label">Custom Body Scripts</label><textarea name="custom_body_scripts" rows="3" class="sg-form-input font-mono text-xs"><?= e($s['custom_body_scripts']) ?></textarea></div>
        </div>
    </div>

    <div class="sg-card p-6">
        <h3 class="font-heading font-bold text-accent mb-4">Schema & Indexing</h3>
        <div class="grid grid-cols-1 gap-4">
            <div><label class="sg-form-label">Person Schema (JSON-LD)</label><textarea name="person_schema" rows="4" class="sg-form-input font-mono text-xs"><?= e($s['person_schema']) ?></textarea></div>
            <div><label class="sg-form-label">Organization Schema (JSON-LD)</label><textarea name="organization_schema" rows="4" class="sg-form-input font-mono text-xs"><?= e($s['organization_schema']) ?></textarea></div>
            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="breadcrumb_schema" value="1" <?= $s['breadcrumb_schema']?'checked':'' ?>> Breadcrumb Schema</label>
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="article_schema" value="1" <?= $s['article_schema']?'checked':'' ?>> Article Schema</label>
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="sitemap_enabled" value="1" <?= $s['sitemap_enabled']?'checked':'' ?>> Enable Sitemap</label>
            </div>
            <div><label class="sg-form-label">Robots.txt Editor</label><textarea name="robots_txt" rows="6" class="sg-form-input font-mono text-xs"><?= e($s['robots_txt']) ?></textarea></div>
        </div>
    </div>

    <button type="submit" class="sg-btn-primary">Save SEO Settings</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
