<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_once __DIR__ . '/../../app/Models/BlogModel.php';
require_once __DIR__ . '/blog-handler.php';

Auth::requireAuth();

$id = (int)($_GET['id'] ?? 0);
$post = BlogModel::find($id);
if (!$post) { flash('error', 'Post not found.'); redirect(base_url('admin/blogs/')); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::validateOrDie();
    process_blog_form($id);
    flash('success', 'Blog post updated.');
    redirect(base_url('admin/blogs/edit.php?id=' . $id));
}

$adminTitle = 'Edit Blog Post';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/seo-preview.php';

$categories = get_db()->query("SELECT * FROM blog_categories WHERE status='active' ORDER BY name")->fetchAll();
$tags = get_db()->query("SELECT * FROM blog_tags ORDER BY name")->fetchAll();
$selectedTags = array_column(BlogModel::getTags($id), 'id');
$faqs = BlogModel::getFaqs($id);
$anchors = BlogModel::getAnchors($id);
$seoCheck = SeoService::calculateBlogSeoScore($post);

include __DIR__ . '/form.php';
require_once __DIR__ . '/../includes/footer.php';
