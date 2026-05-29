<?php
/**
 * One-time local password reset — delete this file after use.
 */
$remote = $_SERVER['REMOTE_ADDR'] ?? '';
if (!in_array($remote, ['127.0.0.1', '::1'], true)) {
    http_response_code(403);
    die('Only available on localhost.');
}

require_once __DIR__ . '/includes/bootstrap.php';

$hash = password_hash('Admin@123', PASSWORD_DEFAULT);
$db = Database::getInstance();
$stmt = $db->prepare('UPDATE admin_users SET password = ? WHERE username = ?');
$stmt->execute([$hash, 'admin']);

if ($stmt->rowCount() < 1) {
    die('No admin user found. Run install.php first.');
}

header('Content-Type: text/html; charset=utf-8');
echo '<!DOCTYPE html><html><body style="font-family:sans-serif;padding:2rem;background:#111;color:#eee">';
echo '<h1>Admin password reset</h1>';
echo '<p>Login at <a href="' . htmlspecialchars(base_url('admin/login.php')) . '" style="color:#F4A933">admin login</a> with:</p>';
echo '<ul><li><strong>Email:</strong> admin@sagarwaiba.com</li>';
echo '<li><strong>Username:</strong> admin</li>';
echo '<li><strong>Password:</strong> Admin@123</li></ul>';
echo '<p style="color:#f88">Delete <code>reset-admin-password.php</code> from the server now.</p>';
echo '</body></html>';
