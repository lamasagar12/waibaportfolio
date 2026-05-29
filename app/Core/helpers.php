<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/CSRF.php';
require_once __DIR__ . '/../Services/SeoService.php';
require_once __DIR__ . '/../Services/ImageService.php';
require_once __DIR__ . '/../Services/SitemapService.php';
require_once __DIR__ . '/../Models/BlogModel.php';

function app_config(string $key = null)
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../../config/app.php';
    }
    return $key ? ($config[$key] ?? null) : $config;
}

function base_url(string $path = ''): string
{
    $base = rtrim(app_config('url'), '/');
    return $path ? $base . '/' . ltrim($path, '/') : $base;
}

function asset_url(string $path): string
{
    return base_url('assets/' . ltrim($path, '/'));
}

function upload_url(string $path = ''): string
{
    $base = rtrim(app_config('upload_url'), '/');
    return $path ? $base . '/' . ltrim($path, '/') : $base;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function flash(string $key, ?string $message = null)
{
    Auth::startSession();
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return;
    }
    $msg = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function old(string $key, string $default = ''): string
{
    Auth::startSession();
    return e($_SESSION['old'][$key] ?? $default);
}

function set_old(array $data): void
{
    Auth::startSession();
    $_SESSION['old'] = $data;
}

function clear_old(): void
{
    Auth::startSession();
    unset($_SESSION['old']);
}

function log_seo_activity(string $entityType, ?int $entityId, string $action, string $description = ''): void
{
    $db = Database::getInstance();
    $stmt = $db->prepare('INSERT INTO seo_activity_log (entity_type, entity_id, action, description) VALUES (?, ?, ?, ?)');
    $stmt->execute([$entityType, $entityId, $action, $description]);
}

function sanitize_html(?string $html): string
{
    if (!$html) return '';
    $allowed = '<h1><h2><h3><h4><h5><h6><p><br><strong><em><u><ul><ol><li><a><img><blockquote><table><thead><tbody><tr><th><td><pre><code><figure><figcaption><div><span><iframe><hr>';
    return strip_tags($html, $allowed);
}

function count_words(string $text): int
{
    $plain = trim(strip_tags($text));
    if ($plain === '') return 0;
    return str_word_count($plain);
}

function reading_time(string $text, int $wpm = 200): int
{
    $words = count_words($text);
    return max(1, (int)ceil($words / $wpm));
}

function seo_score_badge_class(int $score): string
{
    if ($score >= 80) return 'sg-badge-success';
    if ($score >= 50) return 'sg-badge-warning';
    return 'sg-badge-danger';
}

function status_badge(string $status): string
{
    $map = [
        'published' => 'sg-badge-success',
        'draft' => 'sg-badge-muted',
        'scheduled' => 'sg-badge-warning',
        'active' => 'sg-badge-success',
        'inactive' => 'sg-badge-muted',
    ];
    return $map[$status] ?? 'sg-badge-muted';
}

function format_date(?string $date, string $format = 'M d, Y'): string
{
    if (!$date) return '—';
    return date($format, strtotime($date));
}

function json_response(array $data, int $code = 200): void
{
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function get_db(): PDO
{
    return Database::getInstance();
}
