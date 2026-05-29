<?php
/**
 * One-time installer — run via browser then delete or restrict access.
 */
require_once __DIR__ . '/app/Core/helpers.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $config = require __DIR__ . '/config/database.php';
        $dbName = $config['database'] ?? 'sagarportfolio';
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $dbName)) {
            throw new InvalidArgumentException('Invalid database name in config.');
        }
        $pdo = new PDO(
            "mysql:host={$config['host']};port={$config['port']};charset={$config['charset']}",
            $config['username'],
            $config['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $pdo->exec("DROP DATABASE IF EXISTS `{$dbName}`");
        $sql = file_get_contents(__DIR__ . '/database/schema.sql');
        $pdo->exec($sql);

        $pdo->exec("USE `{$dbName}`");
        $password = password_hash('Admin@123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE admin_users SET password = ? WHERE username = ?');
        $stmt->execute([$password, 'admin']);
        if ($stmt->rowCount() < 1) {
            throw new RuntimeException('Admin user password was not set. Check config/database.php database name.');
        }

        $message = 'Database installed successfully! Login: admin@sagarwaiba.com / Admin@123';
    } catch (Exception $e) {
        $error = 'Install failed: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install | Sagar Waiba Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#050505] text-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-[#121212] border border-[#F4A933]/20 rounded-2xl p-8">
        <h1 class="text-2xl font-bold mb-2">Portfolio CMS Installer</h1>
        <p class="text-gray-400 text-sm mb-6">Creates database tables and default admin account.</p>
        <?php if ($message): ?>
            <div class="bg-green-500/10 border border-green-500/30 text-green-400 p-4 rounded-lg mb-4 text-sm"><?= htmlspecialchars($message) ?></div>
            <a href="/sagarportfolio/admin/login.php" class="inline-block bg-[#F4A933] text-black font-semibold px-6 py-2 rounded-full">Go to Admin Login</a>
        <?php else: ?>
            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-lg mb-4 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <p class="text-sm text-gray-400 mb-4">Ensure MySQL is running in XAMPP, then click install. Re-running will reset the database and remove any existing CMS data.</p>
                <button type="submit" class="w-full bg-[#F4A933] text-black font-semibold py-3 rounded-lg hover:bg-[#FFB84D] transition">Install Database</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
