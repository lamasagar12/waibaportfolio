<?php
$adminTitle = 'Tags';
require_once __DIR__ . '/../includes/header.php';
$db = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    if (!empty($_POST['delete_id'])) {
        $db->prepare('DELETE FROM blog_tags WHERE id = ?')->execute([(int)$_POST['delete_id']]);
        flash('success', 'Tag deleted.');
    } else {
        $data = [trim($_POST['name']), slugify($_POST['slug'] ?: $_POST['name']), trim($_POST['description'] ?? '')];
        if (!empty($_POST['id'])) {
            $db->prepare('UPDATE blog_tags SET name=?, slug=?, description=? WHERE id=?')->execute([...$data, (int)$_POST['id']]);
            flash('success', 'Tag updated.');
        } else {
            $db->prepare('INSERT INTO blog_tags (name, slug, description) VALUES (?,?,?)')->execute($data);
            flash('success', 'Tag created.');
        }
    }
    redirect(base_url('admin/tags/'));
}

$tags = $db->query('SELECT * FROM blog_tags ORDER BY name')->fetchAll();
$edit = null;
if (!empty($_GET['edit'])) {
    $stmt = $db->prepare('SELECT * FROM blog_tags WHERE id = ?');
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch();
}
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 sg-card overflow-hidden">
        <table class="sg-table">
            <thead><tr><th>Name</th><th>Slug</th><th>Description</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($tags as $t): ?>
                <tr>
                    <td><?= e($t['name']) ?></td>
                    <td class="text-textMuted text-xs"><?= e($t['slug']) ?></td>
                    <td class="text-sm truncate max-w-xs"><?= e($t['description']) ?></td>
                    <td>
                        <a href="?edit=<?= $t['id'] ?>" class="text-accent text-sm mr-2">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete?')"><?= CSRF::field() ?><input type="hidden" name="delete_id" value="<?= $t['id'] ?>"><button class="text-red-400 text-sm">Delete</button></form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="sg-card p-5">
        <h3 class="font-heading font-bold text-accent mb-4"><?= $edit ? 'Edit' : 'Add' ?> Tag</h3>
        <form method="POST" class="space-y-3">
            <?= CSRF::field() ?>
            <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif; ?>
            <div><label class="sg-form-label">Name</label><input name="name" value="<?= e($edit['name'] ?? '') ?>" required class="sg-form-input"></div>
            <div><label class="sg-form-label">Slug</label><input name="slug" value="<?= e($edit['slug'] ?? '') ?>" class="sg-form-input"></div>
            <div><label class="sg-form-label">Description</label><textarea name="description" rows="2" class="sg-form-input"><?= e($edit['description'] ?? '') ?></textarea></div>
            <button type="submit" class="sg-btn-primary w-full"><?= $edit ? 'Update' : 'Create' ?></button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
