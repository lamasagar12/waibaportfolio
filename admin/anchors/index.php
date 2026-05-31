<?php
$adminTitle = 'Anchor Text Report';
require_once __DIR__ . '/../includes/header.php';

$db = get_db();
$anchors = $db->query(
    'SELECT al.*, bp.title as post_title FROM anchor_links al
     LEFT JOIN blog_posts bp ON bp.id = al.post_id
     ORDER BY al.created_at DESC'
)->fetchAll();

$anchorTexts = array_count_values(array_map(fn($a) => strtolower($a['anchor_text']), $anchors));
$duplicates = array_filter($anchorTexts, fn($c) => $c > 2);
?>

<?php if (!empty($duplicates)): ?>
<div class="sg-card p-4 mb-6 border-accent/30">
    <h4 class="text-accent font-semibold text-sm mb-2 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 15c-.77 1.333.192 3 1.732 3z"></path></svg>
        Exact-Match Anchor Warning
    </h4>
    <p class="text-textSecondary text-xs">These anchor texts appear more than twice — consider varying them:</p>
    <ul class="mt-2 text-xs text-textMuted">
        <?php foreach ($duplicates as $text => $count): ?>
        <li>"<?= e($text) ?>" — used <?= $count ?> times</li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="sg-stat-card"><p class="text-textMuted text-xs">Total Links</p><p class="text-2xl font-bold text-accent"><?= count($anchors) ?></p></div>
    <div class="sg-stat-card"><p class="text-textMuted text-xs">Internal</p><p class="text-2xl font-bold text-accent"><?= count(array_filter($anchors, fn($a) => $a['link_type']==='internal')) ?></p></div>
    <div class="sg-stat-card"><p class="text-textMuted text-xs">External</p><p class="text-2xl font-bold text-accent"><?= count(array_filter($anchors, fn($a) => $a['link_type']==='external')) ?></p></div>
</div>

<div class="sg-card overflow-x-auto">
    <table class="sg-table">
        <thead><tr><th>Anchor Text</th><th>Target URL</th><th>Type</th><th>Rel</th><th>Post</th><th>Location</th></tr></thead>
        <tbody>
            <?php if (empty($anchors)): ?>
            <tr><td colspan="6" class="text-center text-textMuted py-8">No anchor links tracked yet.</td></tr>
            <?php else: foreach ($anchors as $a): ?>
            <tr>
                <td class="font-medium"><?= e($a['anchor_text']) ?></td>
                <td class="text-xs text-accent max-w-xs truncate"><a href="<?= e($a['target_url']) ?>" target="_blank"><?= e($a['target_url']) ?></a></td>
                <td><span class="sg-badge sg-badge-muted"><?= e($a['link_type']) ?></span></td>
                <td class="text-xs"><?= e($a['rel_attribute']) ?></td>
                <td class="text-sm"><?= e($a['post_title'] ?? '—') ?></td>
                <td class="text-xs text-textMuted"><?= e($a['location_hint']) ?></td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
