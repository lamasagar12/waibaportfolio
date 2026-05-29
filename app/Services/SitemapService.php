<?php

class SitemapService
{
    public static function generate(): string
    {
        $db = get_db();
        $base = base_url();
        $urls = [];

        $pages = $db->query('SELECT slug, updated_at FROM page_seo')->fetchAll();
        foreach ($pages as $page) {
            $loc = $page['slug'] === 'home' ? $base . '/' : $base . '/' . $page['slug'] . '.php';
            $urls[] = self::urlNode($loc, $page['updated_at'], 'weekly', '0.8');
        }

        $posts = $db->query("SELECT slug, updated_at FROM blog_posts WHERE status = 'published' ORDER BY publish_date DESC")->fetchAll();
        foreach ($posts as $post) {
            $urls[] = self::urlNode($base . '/blog/' . $post['slug'], $post['updated_at'], 'monthly', '0.7');
        }

        $images = $db->query('SELECT file_url, updated_at, title FROM media_files ORDER BY created_at DESC')->fetchAll();
        foreach ($images as $img) {
            $urls[] = self::urlNode($base . '/uploads/media/' . basename($img['file_url']), $img['updated_at'], 'monthly', '0.3');
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= implode("\n", $urls);
        $xml .= "\n</urlset>";
        return $xml;
    }

    private static function urlNode(string $loc, ?string $lastmod, string $freq, string $priority): string
    {
        $lastmod = $lastmod ? date('Y-m-d', strtotime($lastmod)) : date('Y-m-d');
        return "  <url>\n    <loc>" . htmlspecialchars($loc) . "</loc>\n    <lastmod>$lastmod</lastmod>\n    <changefreq>$freq</changefreq>\n    <priority>$priority</priority>\n  </url>";
    }

    public static function getRobotsTxt(): string
    {
        $settings = SeoService::getGlobalSettings();
        return $settings['robots_txt'] ?? "User-agent: *\nAllow: /\nSitemap: " . base_url('sitemap.xml');
    }
}
