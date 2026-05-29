<?php

class SeoService
{
    public static function getGlobalSettings(): array
    {
        $db = get_db();
        $stmt = $db->query('SELECT * FROM seo_settings ORDER BY id ASC LIMIT 1');
        $settings = $stmt->fetch();
        return $settings ?: [];
    }

    public static function updateGlobalSettings(array $data): bool
    {
        $db = get_db();
        $fields = [
            'website_title', 'website_tagline', 'default_meta_title', 'default_meta_description',
            'default_meta_keywords', 'site_author', 'canonical_url', 'robots_index', 'robots_follow',
            'og_title', 'og_description', 'og_image', 'twitter_title', 'twitter_description', 'twitter_image',
            'twitter_card_type', 'ga4_id', 'gtm_id', 'gsc_verification', 'bing_verification',
            'facebook_pixel_id', 'custom_head_scripts', 'custom_body_scripts',
            'person_schema', 'organization_schema', 'website_schema', 'breadcrumb_schema',
            'article_schema', 'local_business_schema', 'sitemap_enabled', 'robots_txt'
        ];
        $sets = [];
        $values = [];
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $sets[] = "$field = ?";
                $values[] = $data[$field];
            }
        }
        if (empty($sets)) return false;
        $sql = 'UPDATE seo_settings SET ' . implode(', ', $sets) . ' WHERE id = 1';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute($values);
        if ($result) {
            log_seo_activity('seo_settings', 1, 'updated', 'Global SEO settings updated');
        }
        return $result;
    }

    public static function getPageSeo(string $pageKey): ?array
    {
        $db = get_db();
        $stmt = $db->prepare('SELECT * FROM page_seo WHERE page_key = ? LIMIT 1');
        $stmt->execute([$pageKey]);
        return $stmt->fetch() ?: null;
    }

    public static function getAllPages(): array
    {
        $db = get_db();
        return $db->query('SELECT * FROM page_seo ORDER BY id ASC')->fetchAll();
    }

    public static function updatePageSeo(string $pageKey, array $data): bool
    {
        $db = get_db();
        $fields = [
            'page_title', 'meta_title', 'meta_description', 'focus_keyword', 'secondary_keywords',
            'slug', 'canonical_url', 'og_title', 'og_description', 'og_image',
            'twitter_title', 'twitter_description', 'twitter_image',
            'robots_index', 'robots_follow', 'schema_type', 'custom_schema', 'seo_notes'
        ];
        $sets = [];
        $values = [];
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $sets[] = "$field = ?";
                $values[] = $data[$field];
            }
        }
        $values[] = $pageKey;
        $sql = 'UPDATE page_seo SET ' . implode(', ', $sets) . ' WHERE page_key = ?';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute($values);
        if ($result) {
            log_seo_activity('page_seo', null, 'updated', "Page SEO updated: $pageKey");
        }
        return $result;
    }

    public static function buildMeta(array $overrides = [], ?array $pageSeo = null): array
    {
        $global = self::getGlobalSettings();
        $title = $overrides['title'] ?? $pageSeo['meta_title'] ?? $global['default_meta_title'] ?? app_config('name');
        $description = $overrides['description'] ?? $pageSeo['meta_description'] ?? $global['default_meta_description'] ?? '';
        $canonical = $overrides['canonical'] ?? $pageSeo['canonical_url'] ?? $global['canonical_url'] ?? base_url();
        $robotsIndex = $overrides['robots_index'] ?? $pageSeo['robots_index'] ?? $global['robots_index'] ?? 'index';
        $robotsFollow = $overrides['robots_follow'] ?? $pageSeo['robots_follow'] ?? $global['robots_follow'] ?? 'follow';

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $overrides['keywords'] ?? $global['default_meta_keywords'] ?? '',
            'canonical' => $canonical,
            'robots' => "$robotsIndex, $robotsFollow",
            'og_title' => $overrides['og_title'] ?? $pageSeo['og_title'] ?? $title,
            'og_description' => $overrides['og_description'] ?? $pageSeo['og_description'] ?? $description,
            'og_image' => $overrides['og_image'] ?? $pageSeo['og_image'] ?? $global['og_image'] ?? asset_url('images/profile.png'),
            'twitter_title' => $overrides['twitter_title'] ?? $pageSeo['twitter_title'] ?? $title,
            'twitter_description' => $overrides['twitter_description'] ?? $pageSeo['twitter_description'] ?? $description,
            'twitter_image' => $overrides['twitter_image'] ?? $pageSeo['twitter_image'] ?? $global['twitter_image'] ?? asset_url('images/profile.png'),
            'twitter_card' => $overrides['twitter_card'] ?? $global['twitter_card_type'] ?? 'summary_large_image',
            'schema' => $overrides['schema'] ?? null,
            'global' => $global,
        ];
    }

    public static function calculateBlogSeoScore(array $post, ?array $featuredImage = null): array
    {
        $checks = [];
        $score = 0;
        $max = 14;
        $keyword = strtolower(trim($post['focus_keyword'] ?? ''));
        $title = strtolower($post['meta_title'] ?? $post['title'] ?? '');
        $desc = strtolower($post['meta_description'] ?? '');
        $slug = strtolower($post['slug'] ?? '');
        $content = strtolower($post['content'] ?? '');

        $checks['focus_in_title'] = $keyword && str_contains($title, $keyword);
        $checks['focus_in_desc'] = $keyword && str_contains($desc, $keyword);
        $checks['focus_in_slug'] = $keyword && str_contains($slug, str_replace(' ', '-', $keyword));
        $checks['focus_in_first_para'] = $keyword && str_contains(substr(strip_tags($content), 0, 300), $keyword);
        $checks['focus_in_h2'] = $keyword && preg_match('/<h2[^>]*>.*?' . preg_quote($keyword, '/') . '.*?<\/h2>/is', $content);
        $checks['meta_title_length'] = strlen($post['meta_title'] ?? $post['title'] ?? '') >= 30 && strlen($post['meta_title'] ?? $post['title'] ?? '') <= 60;
        $checks['meta_desc_length'] = strlen($post['meta_description'] ?? '') >= 120 && strlen($post['meta_description'] ?? '') <= 160;
        $checks['featured_image'] = !empty($post['featured_image_id']) || !empty($featuredImage);
        $checks['featured_alt'] = !empty($post['featured_image_alt']);
        $checks['internal_links'] = (int)preg_match_all('/href=["\']' . preg_quote(base_url(), '/') . '/i', $post['content'] ?? '') > 0;
        $checks['external_links'] = (int)preg_match_all('/href=["\']https?:\/\//i', $post['content'] ?? '') > 0;
        $checks['word_count'] = ($post['word_count'] ?? 0) >= 600;
        $checks['heading_structure'] = preg_match('/<h2/i', $post['content'] ?? '') && preg_match('/<h3/i', $post['content'] ?? '');
        $checks['schema_enabled'] = true;

        foreach ($checks as $pass) {
            if ($pass) $score++;
        }

        return [
            'score' => (int)round(($score / $max) * 100),
            'checks' => $checks,
        ];
    }

    public static function generateArticleSchema(array $post, ?array $image = null): array
    {
        $global = self::getGlobalSettings();
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post['title'],
            'description' => $post['meta_description'] ?? $post['excerpt'] ?? '',
            'author' => [
                '@type' => 'Person',
                'name' => $post['author_name'] ?? $global['site_author'] ?? 'Sagar Waiba',
            ],
            'datePublished' => date('c', strtotime($post['publish_date'] ?? $post['created_at'])),
            'dateModified' => date('c', strtotime($post['updated_at'] ?? $post['created_at'])),
            'image' => $image['file_url'] ?? asset_url('images/profile.png'),
            'publisher' => [
                '@type' => 'Organization',
                'name' => $global['website_title'] ?? 'Sagar Waiba',
            ],
            'mainEntityOfPage' => base_url('blog/' . $post['slug']),
        ];
    }

    public static function generateFaqSchema(array $faqs): ?array
    {
        if (empty($faqs)) return null;
        $items = [];
        foreach ($faqs as $faq) {
            $items[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($faq['answer']),
                ],
            ];
        }
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $items,
        ];
    }
}
