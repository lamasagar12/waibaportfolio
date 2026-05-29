<?php
$page_key = 'blog';
require_once 'includes/header.php';
require_once 'includes/page-helpers.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$filters = ['status' => 'published'];
if ($search) $filters['search'] = $search;
if ($category) $filters['category_id'] = (int)$category;

try {
    $result = BlogModel::all($filters, $page, 9);
    $posts = $result['data'];
    $totalPages = $result['pages'];
    $categories = get_db()->query("SELECT * FROM blog_categories WHERE status = 'active' ORDER BY name")->fetchAll();
} catch (Exception $e) {
    $posts = [];
    $totalPages = 0;
    $categories = [];
}

sg_page_hero('SEO <span>Blog</span>', 'Insights, strategies, and digital growth tips.');
?>
<section class="px-6 pb-20">
    <div class="max-w-7xl mx-auto">
        <form method="GET" class="flex flex-wrap gap-3 mb-10 justify-center animate-on-scroll">
            <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search articles..." class="sg-form-input max-w-xs">
            <select name="category" class="sg-form-input max-w-xs" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="sg-btn-primary">Search</button>
        </form>

        <?php if (empty($posts)): ?>
        <div class="text-center py-16 text-textMuted">
            <p class="text-lg mb-2">No blog posts yet.</p>
            <p class="text-sm">Create your first post in the admin panel.</p>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($posts as $post): ?>
            <article class="sg-card overflow-hidden animate-on-scroll">
                <a href="<?= base_url('blog/' . $post['slug']) ?>">
                    <?php if ($post['featured_image_url']): ?>
                    <img src="<?= e($post['featured_image_url']) ?>" alt="<?= e($post['featured_image_alt'] ?? $post['title']) ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                    <div class="w-full h-48 bg-tertiary flex items-center justify-center text-4xl text-accent/20">📝</div>
                    <?php endif; ?>
                </a>
                <div class="p-5">
                    <div class="flex items-center gap-3 text-xs text-textMuted mb-2">
                        <span class="text-accent font-semibold"><?= e($post['category_name'] ?? 'Blog') ?></span>
                        <span>·</span>
                        <time datetime="<?= e($post['publish_date']) ?>"><?= format_date($post['publish_date']) ?></time>
                        <span>·</span>
                        <span><?= (int)$post['reading_time'] ?> min read</span>
                    </div>
                    <h2 class="font-heading font-bold text-lg mb-2">
                        <a href="<?= base_url('blog/' . $post['slug']) ?>" class="hover:text-accent transition"><?= e($post['title']) ?></a>
                    </h2>
                    <p class="text-textSecondary text-sm line-clamp-3 mb-4"><?= e($post['excerpt']) ?></p>
                    <a href="<?= base_url('blog/' . $post['slug']) ?>" class="text-accent text-sm font-semibold hover:underline">Read More →</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php if ($totalPages > 1): ?>
        <div class="flex justify-center gap-2 mt-10">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="px-3 py-1 rounded <?= $i === $page ? 'bg-accent text-black' : 'bg-tertiary text-textSecondary hover:text-accent' ?> text-sm"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
