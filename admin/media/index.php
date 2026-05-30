<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
Auth::requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    if (!empty($_POST['delete_id'])) {
        ImageService::delete((int)$_POST['delete_id']);
        flash('success', 'Image deleted.');
        redirect(base_url('admin/media/'));
    }
    if (!empty($_POST['update_id'])) {
        ImageService::update((int)$_POST['update_id'], $_POST);
        flash('success', 'Image updated.');
        redirect(base_url('admin/media/'));
    }
    if (!empty($_FILES['upload']['name'])) {
        $result = ImageService::upload($_FILES['upload'], ['alt_text' => $_POST['alt_text'] ?? '']);
        flash($result ? 'success' : 'error', $result ? 'Image uploaded.' : 'Upload failed.');
        redirect(base_url('admin/media/'));
    }
}

$filters = [];
if (!empty($_GET['search'])) $filters['search'] = $_GET['search'];
$media = ImageService::all($filters);

$adminTitle = 'Media Library';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="sg-card p-5 mb-6">
    <h3 class="font-heading font-bold text-accent mb-4">Upload Image</h3>
    <form method="POST" enctype="multipart/form-data" class="flex flex-wrap gap-3 items-end">
        <?= CSRF::field() ?>
        <div class="flex-1 min-w-[200px]"><label class="sg-form-label">File</label><input type="file" name="upload" accept="image/*" required class="sg-form-input"></div>
        <div class="flex-1 min-w-[200px]"><label class="sg-form-label">Alt Text</label><input name="alt_text" class="sg-form-input"></div>
        <button type="submit" class="sg-btn-primary">Upload</button>
    </form>
</div>

<form method="GET" class="mb-4"><input type="text" name="search" value="<?= e($_GET['search'] ?? '') ?>" placeholder="Search..." class="sg-form-input max-w-xs"></form>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
    <?php if (empty($media)): ?>
    <p class="col-span-full text-textMuted text-center py-8">No media files yet.</p>
    <?php else: foreach ($media as $m): ?>
    <div class="sg-card p-3">
        <img src="<?= e($m['file_url']) ?>" alt="<?= e($m['alt_text']) ?>" class="w-full h-32 object-cover rounded mb-2">
        <p class="text-xs truncate text-textMuted mb-2"><?= e($m['original_name']) ?></p>
        <input type="text" value="<?= e(base_url('uploads/media/' . $m['filename'])) ?>" readonly class="sg-form-input text-xs mb-2" onclick="this.select();document.execCommand('copy')">
        <form method="POST" class="space-y-1">
            <?= CSRF::field() ?>
            <input type="hidden" name="update_id" value="<?= $m['id'] ?>">
            <input name="alt_text" value="<?= e($m['alt_text']) ?>" placeholder="Alt" class="sg-form-input text-xs">
            <input name="title" value="<?= e($m['title']) ?>" placeholder="Title" class="sg-form-input text-xs">
            <button type="submit" class="text-accent text-xs w-full">Save</button>
        </form>
        <form method="POST" onsubmit="return confirm('Delete?')" class="mt-1"><?= CSRF::field() ?><input type="hidden" name="delete_id" value="<?= $m['id'] ?>"><button class="text-red-400 text-xs w-full">Delete</button></form>
    </div>
    <?php endforeach; endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
