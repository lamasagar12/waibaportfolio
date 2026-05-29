<?php
$adminTitle = 'Categories';
require_once __DIR__ . '/../includes/header.php';
$db = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    if (!empty($_POST['delete_id'])) {
        $db->prepare('DELETE FROM blog_categories WHERE id = ?')->execute([(int)$_POST['delete_id']]);
        flash('success', 'Category deleted.');
    } else {
        $data = [trim($_POST['name']), slugify($_POST['slug'] ?: $_POST['name']), trim($_POST['description'] ?? ''), trim($_POST['meta_title'] ?? ''), trim($_POST['meta_description'] ?? '')];
        if (!empty($_POST['id'])) {
            $db->prepare('UPDATE blog_categories SET name=?, slug=?, description=?, meta_title=?, meta_description=? WHERE id=?')->execute([...$data, (int)$_POST['id']]);
            flash('success', 'Category updated.');
        } else {
            $db->prepare('INSERT INTO blog_categories (name, slug, description, meta_title, meta_description) VALUES (?,?,?,?,?)')->execute($data);
            flash('success', 'Category created.');
        }
    }
    redirect(base_url('admin/categories/'));
}

$categories = $db->query('SELECT * FROM blog_categories ORDER BY name')->fetchAll();
$edit = null;
if (!empty($_GET['edit'])) {
    $stmt = $db->prepare('SELECT * FROM blog_categories WHERE id = ?');
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch();
}
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 sg-card overflow-hidden">
        <table class="sg-table">
            <thead><tr><th>Name</th><th>Slug</th><th>Meta Title</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($categories as $c): ?>
                <tr>
                    <td><?= e($c['name']) ?></td>
                    <td class="text-textMuted text-xs"><?= e($c['slug']) ?></td>
                    <td class="text-sm truncate max-w-xs"><?= e($c['meta_title']) ?></td>
                    <td>
                        <a href="?edit=<?= $c['id'] ?>" class="text-accent text-sm mr-2">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete?')"><?= CSRF::field() ?><input type="hidden" name="delete_id" value="<?= $c['id'] ?>"><button class="text-red-400 text-sm">Delete</button></form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="sg-card p-5">
        <h3 class="font-heading font-bold text-accent mb-4"><?= $edit ? 'Edit' : 'Add' ?> Category</h3>
        <form method="POST" class="space-y-3">
            <?= CSRF::field() ?>
            <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif; ?>
            <div><label class="sg-form-label">Name</label><input name="name" value="<?= e($edit['name'] ?? '') ?>" required class="sg-form-input"></div>
            <div><label class="sg-form-label">Slug</label><input name="slug" value="<?= e($edit['slug'] ?? '') ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">Description</label><textarea name="description" rows="2" class="sg-form-input"><?= e($edit['description'] ?? '') ?></textarea></div>
            <div><label class="sg-form-label">Meta Title</label><input name="meta_title" value="<?= e($edit['meta_title'] ?? '') ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">Meta Description</label><textarea name="meta_description" rows="2" class="sg-form-input"><?= e($edit['meta_description'] ?? '') ?></textarea></div>
            <button type="submit" class="sg-btn-primary w-full"><?= $edit ? 'Update' : 'Create' ?></button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
