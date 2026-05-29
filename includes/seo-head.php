<?php
require_once __DIR__ . '/bootstrap.php';

function render_seo_head(array $meta): void
{
    $global = $meta['global'] ?? SeoService::getGlobalSettings();
    ?>
    <title><?= e($meta['title']) ?></title>
    <meta name="description" content="<?= e($meta['description']) ?>">
    <?php if (!empty($meta['keywords'])): ?>
    <meta name="keywords" content="<?= e($meta['keywords']) ?>">
    <?php endif; ?>
    <meta name="author" content="<?= e($global['site_author'] ?? 'Sagar Waiba') ?>">
    <meta name="robots" content="<?= e($meta['robots']) ?>">
    <link rel="canonical" href="<?= e($meta['canonical']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= e($meta['og_title']) ?>">
    <meta property="og:description" content="<?= e($meta['og_description']) ?>">
    <meta property="og:image" content="<?= e($meta['og_image']) ?>">
    <meta property="og:url" content="<?= e($meta['canonical']) ?>">
    <meta name="twitter:card" content="<?= e($meta['twitter_card']) ?>">
    <meta name="twitter:title" content="<?= e($meta['twitter_title']) ?>">
    <meta name="twitter:description" content="<?= e($meta['twitter_description']) ?>">
    <meta name="twitter:image" content="<?= e($meta['twitter_image']) ?>">
    <?php if (!empty($global['gsc_verification'])): ?>
    <meta name="google-site-verification" content="<?= e($global['gsc_verification']) ?>">
    <?php endif; ?>
    <?php if (!empty($global['bing_verification'])): ?>
    <meta name="msvalidate.01" content="<?= e($global['bing_verification']) ?>">
    <?php endif; ?>
    <?php if (!empty($global['ga4_id'])): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($global['ga4_id']) ?>"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e($global['ga4_id']) ?>');</script>
    <?php endif; ?>
    <?php if (!empty($global['gtm_id'])): ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?= e($global['gtm_id']) ?>');</script>
    <?php endif; ?>
    <?php if (!empty($global['custom_head_scripts'])) echo $global['custom_head_scripts']; ?>
    <?php if (!empty($meta['schema'])): ?>
    <script type="application/ld+json"><?= json_encode($meta['schema'], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?></script>
    <?php endif;
}
