<?php
require_once __DIR__ . '/../includes/bootstrap.php';
if (Auth::check()) redirect(base_url('admin/'));

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    if (Auth::attempt($login, $password)) {
        redirect(base_url('admin/'));
    }
    $error = 'Invalid email/username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Sagar Waiba</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="sg-admin-body flex items-center justify-center min-h-screen p-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="<?= asset_url('images/profile.png') ?>" alt="Sagar Waiba" class="w-20 h-20 rounded-full mx-auto ring-4 ring-accent/30 mb-4">
            <h1 class="font-heading text-2xl font-bold">Admin <span class="text-accent">Login</span></h1>
            <p class="text-textMuted text-sm mt-1">Sagar Waiba Portfolio CMS</p>
        </div>
        <div class="sg-card p-8">
            <?php if ($error): ?><div class="bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-lg mb-4 text-sm"><?= e($error) ?></div><?php endif; ?>
            <form method="POST" class="space-y-4">
                <?= CSRF::field() ?>
                <div>
                    <label class="sg-form-label">Email or Username</label>
                    <input type="text" name="login" required class="sg-form-input" autofocus>
                </div>
                <div>
                    <label class="sg-form-label">Password</label>
                    <input type="password" name="password" required class="sg-form-input">
                </div>
                <button type="submit" class="sg-btn-primary w-full">Sign In</button>
            </form>
            <div class="text-center mt-4">
                <a href="<?= base_url('admin/forgot-password.php') ?>" class="text-accent text-sm hover:underline">Forgot password?</a>
            </div>
        </div>
        <p class="text-center text-textMuted text-xs mt-6"><a href="<?= base_url() ?>" class="hover:text-accent">← Back to website</a></p>
    </div>
</body>
</html>
