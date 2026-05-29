<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
Auth::requireAuth();

function process_blog_form(?int $id = null): void
{
    $db = get_db();
    $content = $_POST['content'] ?? '';
    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'slug' => slugify($_POST['slug'] ?? ''),
        'excerpt' => trim($_POST['excerpt'] ?? ''),
        'content' => sanitize_html($content),
        'category_id' => (int)($_POST['category_id'] ?? 0) ?: null,
        'author_id' => Auth::id(),
        'author_name' => trim($_POST['author_name'] ?? Auth::user()['name']),
        'status' => $_POST['status'] ?? 'draft',
        'publish_date' => $_POST['publish_date'] ?: null,
        'meta_title' => trim($_POST['meta_title'] ?? ''),
        'meta_description' => trim($_POST['meta_description'] ?? ''),
        'focus_keyword' => trim($_POST['focus_keyword'] ?? ''),
        'secondary_keywords' => trim($_POST['secondary_keywords'] ?? ''),
        'lsi_keywords' => trim($_POST['lsi_keywords'] ?? ''),
        'canonical_url' => trim($_POST['canonical_url'] ?? ''),
        'robots_index' => $_POST['robots_index'] ?? 'index',
        'robots_follow' => $_POST['robots_follow'] ?? 'follow',
        'og_title' => trim($_POST['og_title'] ?? ''),
        'og_description' => trim($_POST['og_description'] ?? ''),
        'twitter_title' => trim($_POST['twitter_title'] ?? ''),
        'twitter_description' => trim($_POST['twitter_description'] ?? ''),
        'twitter_card_type' => $_POST['twitter_card_type'] ?? 'summary_large_image',
        'custom_schema' => $_POST['custom_schema'] ?? null,
        'featured_image_alt' => trim($_POST['featured_image_alt'] ?? ''),
        'featured_image_title' => trim($_POST['featured_image_title'] ?? ''),
        'featured_image_caption' => trim($_POST['featured_image_caption'] ?? ''),
        'featured_image_description' => trim($_POST['featured_image_description'] ?? ''),
    ];

    if (!empty($_FILES['featured_image']['name'])) {
        $up = ImageService::upload($_FILES['featured_image'], ['alt_text' => $data['featured_image_alt']]);
        if ($up) $data['featured_image_id'] = $up['id'];
    } elseif (!empty($_POST['featured_image_id'])) {
        $data['featured_image_id'] = (int)$_POST['featured_image_id'];
    }

    $tags = array_filter(array_map('intval', $_POST['tags'] ?? []));
    $faqs = [];
    foreach ($_POST['faq_question'] ?? [] as $i => $q) {
        if (trim($q)) $faqs[] = ['question' => $q, 'answer' => $_POST['faq_answer'][$i] ?? ''];
    }

    $anchors = [];
    foreach ($_POST['anchor_text'] ?? [] as $i => $text) {
        if (trim($text)) {
            $anchors[] = [
                'anchor_text' => $text,
                'target_url' => $_POST['anchor_url'][$i] ?? '',
                'link_type' => $_POST['anchor_type'][$i] ?? 'internal',
                'rel_attribute' => $_POST['anchor_rel'][$i] ?? 'follow',
                'open_new_tab' => !empty($_POST['anchor_newtab'][$i]),
                'location_hint' => $_POST['anchor_location'][$i] ?? '',
            ];
        }
    }
    $data['tags'] = $tags;
    $data['faqs'] = $faqs;
    $data['anchors'] = $anchors;

    BlogModel::save($data, $id);
}
