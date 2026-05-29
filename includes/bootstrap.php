<?php
require_once __DIR__ . '/../app/Core/helpers.php';

Auth::startSession();

date_default_timezone_set(app_config('timezone'));

if (!function_exists('render_seo_head')) {
    function render_seo_head(array $meta = []): void
    {
        $title = $meta['title'] ?? 'Sagar Waiba | SEO Expert Portfolio';
        $description = $meta['description'] ?? 'Professional SEO portfolio of Sagar Waiba, SEO expert specializing in technical SEO, local SEO, content strategy, and digital growth.';
        $keywords = $meta['keywords'] ?? 'Sagar Waiba, SEO Expert Nepal, SEO Portfolio, Technical SEO, Local SEO, Digital Marketing';
        $robots = $meta['robots'] ?? 'index, follow';

        $canonical = $meta['canonical'] ?? '';

        if (empty($canonical)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $canonical = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        $ogTitle = $meta['og_title'] ?? $title;
        $ogDescription = $meta['og_description'] ?? $description;
        $ogType = $meta['og_type'] ?? 'website';
        $ogUrl = $meta['og_url'] ?? $canonical;
        $ogImage = $meta['og_image'] ?? '';

        echo '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>' . PHP_EOL;
        echo '<meta name="description" content="' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        echo '<meta name="keywords" content="' . htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        echo '<meta name="robots" content="' . htmlspecialchars($robots, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        echo '<link rel="canonical" href="' . htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;

        echo '<meta property="og:title" content="' . htmlspecialchars($ogTitle, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        echo '<meta property="og:description" content="' . htmlspecialchars($ogDescription, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        echo '<meta property="og:type" content="' . htmlspecialchars($ogType, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        echo '<meta property="og:url" content="' . htmlspecialchars($ogUrl, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;

        if (!empty($ogImage)) {
            echo '<meta property="og:image" content="' . htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        }

        echo '<meta name="twitter:card" content="summary_large_image">' . PHP_EOL;
        echo '<meta name="twitter:title" content="' . htmlspecialchars($ogTitle, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        echo '<meta name="twitter:description" content="' . htmlspecialchars($ogDescription, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;

        if (!empty($ogImage)) {
            echo '<meta name="twitter:image" content="' . htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        }

        if (!empty($meta['schema'])) {
            echo '<script type="application/ld+json">' . PHP_EOL;
            echo json_encode($meta['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            echo PHP_EOL . '</script>' . PHP_EOL;
        }
    }
}