<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
Auth::requireAuth();
CSRF::validateOrDie();
$id = (int)($_POST['id'] ?? 0);
if ($id) BlogModel::delete($id);
flash('success', 'Blog post deleted.');
redirect(base_url('admin/blogs/'));
