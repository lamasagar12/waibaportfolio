<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
Auth::requireAuth();

$db = get_db();
$user = Auth::user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    if (!empty($_POST['new_password'])) {
        if (strlen($_POST['new_password']) < 8) {
            flash('error', 'Password must be at least 8 characters.');
        } else {
            $hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $db->prepare('UPDATE admin_users SET password = ? WHERE id = ?')->execute([$hash, $user['id']]);
            flash('success', 'Password updated.');
        }
    } else {
        $db->prepare('UPDATE admin_users SET name = ?, email = ? WHERE id = ?')->execute([
            trim($_POST['name']), trim($_POST['email']), $user['id']
        ]);
        $_SESSION['admin_name'] = trim($_POST['name']);
        $_SESSION['admin_email'] = trim($_POST['email']);
        flash('success', 'Profile updated.');
    }
    redirect(base_url('admin/profile/'));
}

$stmt = $db->prepare('SELECT * FROM admin_users WHERE id = ?');
$stmt->execute([$user['id']]);
$profile = $stmt->fetch();

$adminTitle = 'Profile';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-lg sg-card p-6">
    <div class="flex items-center gap-4 mb-6">
        <img src="<?= asset_url('images/profile.png') ?>" class="w-16 h-16 rounded-full ring-2 ring-accent/30" alt="">
        <div>
            <h3 class="font-heading font-bold"><?= e($profile['name']) ?></h3>
            <p class="text-textMuted text-sm"><?= e($profile['email']) ?></p>
            <p class="text-textMuted text-xs">Last login: <?= format_date($profile['last_login'], 'M d, Y H:i') ?></p>
        </div>
    </div>
    <form method="POST" class="space-y-4">
        <?= CSRF::field() ?>
        <div><label class="sg-form-label">Name</label><input name="name" value="<?= e($profile['name']) ?>" class="sg-form-input"></div>
        <div><label class="sg-form-label">Email</label><input name="email" type="email" value="<?= e($profile['email']) ?>" class="sg-form-input"></div>
        <hr class="border-white/10">
        <div><label class="sg-form-label">New Password (leave blank to keep)</label><input name="new_password" type="password" minlength="8" class="sg-form-input"></div>
        <button type="submit" class="sg-btn-primary">Save Profile</button>
    </form>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
