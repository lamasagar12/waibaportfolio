<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_once __DIR__ . '/blog-handler.php';
Auth::requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    process_blog_form();
    flash('success', 'Blog post created.');
    redirect(base_url('admin/blogs/'));
}

$adminTitle = 'Create Blog Post';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/seo-preview.php';

$categories = get_db()->query("SELECT * FROM blog_categories WHERE status='active' ORDER BY name")->fetchAll();
$tags = get_db()->query("SELECT * FROM blog_tags ORDER BY name")->fetchAll();
$post = null;
$selectedTags = [];
$faqs = [];
$anchors = [];

include __DIR__ . '/form.php';
require_once __DIR__ . '/../includes/footer.php';
?>
