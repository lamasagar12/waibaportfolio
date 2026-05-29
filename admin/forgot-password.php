<?php
require_once __DIR__ . '/../includes/bootstrap.php';
if (Auth::check()) redirect(base_url('admin/'));

$message = '';
$error = '';
$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    if (!empty($_POST['token'])) {
        if (strlen($_POST['password'] ?? '') < 8) {
            $error = 'Password must be at least 8 characters.';
        } elseif ($_POST['password'] !== $_POST['password_confirm']) {
            $error = 'Passwords do not match.';
        } elseif (Auth::resetPassword($_POST['token'], $_POST['password'])) {
            flash('success', 'Password reset successfully. Please login.');
            redirect(base_url('admin/login.php'));
        } else {
            $error = 'Invalid or expired reset token.';
        }
    } else {
        $email = trim($_POST['email'] ?? '');
        $token = Auth::createResetToken($email);
        if ($token) {
            $resetLink = base_url('admin/forgot-password.php?token=' . $token);
            $message = 'Reset link generated (dev mode): <a href="' . e($resetLink) . '" class="text-accent underline">' . e($resetLink) . '</a>';
        } else {
            $message = 'If that email exists, a reset link has been sent.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | SG Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="sg-admin-body flex items-center justify-center min-h-screen p-6">
    <div class="w-full max-w-md sg-card p-8">
        <h1 class="font-heading text-xl font-bold mb-4">Reset <span class="text-accent">Password</span></h1>
        <?php if ($message): ?><div class="bg-green-500/10 border border-green-500/30 text-green-400 p-3 rounded-lg mb-4 text-sm"><?= $message ?></div><?php endif; ?>
        <?php if ($error): ?><div class="bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-lg mb-4 text-sm"><?= e($error) ?></div><?php endif; ?>

        <?php if ($token || !empty($_GET['token'])): ?>
        <form method="POST" class="space-y-4">
            <?= CSRF::field() ?>
            <input type="hidden" name="token" value="<?= e($_GET['token'] ?? $token) ?>">
            <div><label class="sg-form-label">New Password</label><input type="password" name="password" required minlength="8" class="sg-form-input"></div>
            <div><label class="sg-form-label">Confirm Password</label><input type="password" name="password_confirm" required class="sg-form-input"></div>
            <button type="submit" class="sg-btn-primary w-full">Reset Password</button>
        </form>
        <?php else: ?>
        <form method="POST" class="space-y-4">
            <?= CSRF::field() ?>
            <div><label class="sg-form-label">Email Address</label><input type="email" name="email" required class="sg-form-input"></div>
            <button type="submit" class="sg-btn-primary w-full">Send Reset Link</button>
        </form>
        <?php endif; ?>
        <a href="<?= base_url('admin/login.php') ?>" class="block text-center text-accent text-sm mt-4">← Back to login</a>
    </div>
</body>
</html>
