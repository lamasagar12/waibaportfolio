<?php
$adminTitle = 'Blog Posts';
require_once __DIR__ . '/../includes/header.php';

$filters = [];
if (!empty($_GET['status'])) $filters['status'] = $_GET['status'];
if (!empty($_GET['category'])) $filters['category_id'] = (int)$_GET['category'];
if (!empty($_GET['search'])) $filters['search'] = $_GET['search'];
$page = max(1, (int)($_GET['page'] ?? 1));

try {
    $result = BlogModel::all($filters, $page, 15);
    $posts = $result['data'];
    $totalPages = $result['pages'];
    $categories = get_db()->query("SELECT id, name FROM blog_categories ORDER BY name")->fetchAll();
} catch (Exception $e) {
    $posts = []; $totalPages = 0; $categories = [];
}
?>

<div class="flex flex-wrap gap-3 mb-6 justify-between items-center">
    <form method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="<?= e($_GET['search'] ?? '') ?>" placeholder="Search..." class="sg-form-input max-w-xs">
        <select name="status" class="sg-form-input">
            <option value="">All Status</option>
            <?php foreach (['published','draft','scheduled'] as $st): ?>
            <option value="<?= $st ?>" <?= ($_GET['status'] ?? '') === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="category" class="sg-form-input">
            <option value="">All Categories</option>
            <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>" <?= ($_GET['category'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="sg-btn-outline text-sm">Filter</button>
    </form>
    <a href="<?= base_url('admin/blogs/create.php') ?>" class="sg-btn-primary text-sm">+ New Post</a>
</div>

<div class="sg-card overflow-x-auto">
    <table class="sg-table">
        <thead>
            <tr>
                <th>Image</th><th>Title</th><th>Slug</th><th>Category</th><th>Status</th><th>SEO</th><th>Published</th><th>Updated</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($posts)): ?>
            <tr><td colspan="9" class="text-center text-textMuted py-8">No blog posts found. <a href="<?= base_url('admin/blogs/create.php') ?>" class="text-accent">Create one</a></td></tr>
            <?php else: foreach ($posts as $post): ?>
            <tr>
                <td><?php if ($post['featured_image_url']): ?><img src="<?= e($post['featured_image_url']) ?>" class="w-12 h-12 object-cover rounded" alt=""><?php else: ?><span class="text-textMuted">—</span><?php endif; ?></td>
                <td class="font-medium max-w-xs truncate"><?= e($post['title']) ?></td>
                <td class="text-textMuted text-xs"><?= e($post['slug']) ?></td>
                <td class="text-sm"><?= e($post['category_name'] ?? '—') ?></td>
                <td><span class="sg-badge <?= status_badge($post['status']) ?>"><?= e($post['status']) ?></span></td>
                <td><span class="sg-badge <?= seo_score_badge_class($post['seo_score']) ?>"><?= $post['seo_score'] ?>%</span></td>
                <td class="text-xs text-textMuted"><?= format_date($post['publish_date']) ?></td>
                <td class="text-xs text-textMuted"><?= format_date($post['updated_at']) ?></td>
                <td class="whitespace-nowrap">
                    <a href="<?= base_url('admin/blogs/edit.php?id=' . $post['id']) ?>" class="text-accent text-sm mr-2">Edit</a>
                    <?php if ($post['status'] === 'published'): ?>
                    <a href="<?= base_url('blog/' . $post['slug']) ?>" target="_blank" class="text-textSecondary text-sm mr-2">View</a>
                    <?php endif; ?>
                    <form method="POST" action="<?= base_url('admin/blogs/delete.php') ?>" class="inline" id="del-<?= $post['id'] ?>">
                        <?= CSRF::field() ?><input type="hidden" name="id" value="<?= $post['id'] ?>">
                        <button type="button" onclick="sgDeleteModal('del-<?= $post['id'] ?>')" class="text-red-400 text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPages > 1): ?>
<div class="flex justify-center gap-2 mt-4">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>&<?= http_build_query(array_filter(['status'=>$_GET['status']??'','search'=>$_GET['search']??'','category'=>$_GET['category']??''])) ?>" class="px-3 py-1 rounded text-sm <?= $i===$page?'bg-accent text-black':'bg-tertiary text-textSecondary' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
