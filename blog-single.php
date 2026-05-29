<?php
require_once 'includes/bootstrap.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) { redirect(base_url('blog.php')); }

try {
    $post = BlogModel::findBySlug($slug);
} catch (Exception $e) {
    $post = null;
}

if (!$post) {
    http_response_code(404);
    $page_key = 'blog';
    require_once 'includes/header.php';
    echo '<section class="px-6 py-32 text-center"><h1 class="text-3xl font-bold mb-4">Post Not Found</h1><a href="' . base_url('blog.php') . '" class="text-accent">← Back to Blog</a></section>';
    require_once 'includes/footer.php';
    exit;
}

$tags = BlogModel::getTags($post['id']);
$faqs = BlogModel::getFaqs($post['id']);
$related = BlogModel::related($post['id'], $post['category_id']);
$nav = BlogModel::prevNext($post['id'], $post['publish_date']);

// Setup meta for header
$page_key = 'blog';
$page_title = $post['meta_title'] ?: $post['title'];
$page_description = $post['meta_description'] ?: $post['excerpt'];

require_once 'includes/header.php';
?>

<nav class="max-w-4xl mx-auto px-6 py-4 text-sm text-textMuted" aria-label="Breadcrumb">
    <a href="<?= base_url() ?>" class="hover:text-accent font-mono text-[10px] uppercase tracking-widest">Home</a> 
    <span class="mx-2 text-white/10">/</span>
    <a href="<?= base_url('blog.php') ?>" class="hover:text-accent font-mono text-[10px] uppercase tracking-widest">Blog</a> 
    <span class="mx-2 text-white/10">/</span>
    <span class="text-accent font-mono text-[10px] uppercase tracking-widest"><?= e($post['title']) ?></span>
</nav>

<article class="max-w-4xl mx-auto px-6 pb-20">
    <header class="mb-12 animate-on-scroll">
        <span class="inline-block px-3 py-1 rounded-full bg-accent/10 border border-accent/20 text-accent text-[10px] font-mono uppercase tracking-widest mb-6">
            <?= e($post['category_name'] ?? 'Blog') ?>
        </span>
        <h1 class="font-heading text-4xl md:text-6xl font-normal mb-8 leading-[1.1] text-textPrimary">
            <?= e($post['title']) ?>
        </h1>
        <div class="flex flex-wrap gap-6 text-[10px] font-mono uppercase tracking-widest text-textMuted border-b border-white/5 pb-8">
            <div class="flex items-center gap-2">
                <span class="text-accent">👤</span>
                <span>By <?= e($post['author_name'] ?? 'Sagar Waiba') ?></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-accent">📅</span>
                <time datetime="<?= e($post['publish_date']) ?>"><?= format_date($post['publish_date']) ?></time>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-accent">⏱️</span>
                <span><?= (int)$post['reading_time'] ?> min read</span>
            </div>
        </div>
    </header>

    <?php if ($post['featured_image_url']): ?>
    <figure class="mb-16 animate-on-scroll relative group">
        <div class="absolute -inset-2 bg-accent/10 rounded-3xl blur-2xl opacity-0 group-hover:opacity-100 transition duration-1000"></div>
        <img src="<?= e($post['featured_image_url']) ?>" alt="<?= e($post['featured_image_alt'] ?? $post['title']) ?>" class="relative w-full rounded-2xl ring-1 ring-white/5 shadow-glow">
        <?php if ($post['featured_image_caption']): ?>
        <figcaption class="text-textMuted text-xs font-mono mt-4 text-center tracking-wide uppercase italic">
            // <?= e($post['featured_image_caption']) ?>
        </figcaption>
        <?php endif; ?>
    </figure>
    <?php endif; ?>

    <div class="sg-blog-content animate-on-scroll text-textPrimary selection:bg-accent/30" id="blog-content">
        <?= $post['content'] ?>
    </div>

    <?php if (!empty($tags)): ?>
    <div class="flex flex-wrap gap-3 mt-16 pt-8 border-t border-white/5">
        <?php foreach ($tags as $tag): ?>
        <span class="px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-textMuted text-[10px] font-mono uppercase tracking-widest hover:border-accent/30 hover:text-accent transition-colors">
            # <?= e($tag['name']) ?>
        </span>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($faqs)): ?>
    <section class="mt-20 animate-on-scroll">
        <h2 class="font-heading text-3xl mb-10">Frequently Asked <span>Questions</span></h2>
        <div class="space-y-4">
            <?php foreach ($faqs as $faq): ?>
            <details class="sg-card group">
                <summary class="p-6 font-bold cursor-pointer list-none flex justify-between items-center group-open:text-accent transition-colors">
                    <span class="text-lg"><?= e($faq['question']) ?></span>
                    <span class="text-accent text-xl transition-transform group-open:rotate-180">↓</span>
                </summary>
                <div class="px-6 pb-6 text-textMuted leading-relaxed font-sans border-t border-white/5 pt-4">
                    <?= $faq['answer'] ?>
                </div>
            </details>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Author Bio Section -->
    <div class="mt-16 p-8 sg-card border-l-4 border-l-accent animate-on-scroll">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="relative shrink-0">
                <div class="absolute inset-0 bg-accent/20 rounded-full blur-xl animate-pulse"></div>
                <img src="<?= asset_url('images/profile.png') ?>" alt="Sagar Waiba" class="relative w-24 h-24 rounded-full ring-2 ring-accent/30 object-cover shadow-glow">
            </div>
            <div class="text-center md:text-left">
                <h4 class="font-heading text-2xl text-textPrimary mb-1">About <span class="text-accent">Sagar Waiba</span></h4>
                <p class="text-accentLight text-[10px] font-mono uppercase tracking-widest mb-3">SEO Specialist | Link Building | Digital Marketing Strategy</p>
                <p class="text-textMuted text-sm leading-relaxed mb-4">
                    Sagar Waiba is a results-driven SEO professional based in Nepal, specializing in technical optimization and high-authority link building. He helps brands scale their organic visibility through data-backed strategies and precise execution.
                </p>
                <div class="flex justify-center md:justify-start gap-4">
                    <a href="https://www.linkedin.com/in/sagar-tamang-waiba/" target="_blank" class="text-accent text-xs font-bold hover:underline italic">// Connect on LinkedIn</a>
                    <a href="<?= base_url('about.php') ?>" class="text-textMuted text-xs font-bold hover:text-accent italic">// Read Full Bio</a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 mt-20 p-8 sg-card items-center justify-between">
        <div class="text-sm font-mono uppercase tracking-widest text-textMuted">Share this Insight</div>
        <div class="flex gap-3">
            <?php
            $shareUrl = urlencode(base_url('blog/' . $post['slug']));
            $shareTitle = urlencode($post['title']);
            ?>
            <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300">𝕏</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300">fb</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $shareUrl ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300">li</a>
        </div>
    </div>

    <nav class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
        <?php if ($nav['prev'] ?? null): ?>
        <a href="<?= base_url('blog/' . $nav['prev']['slug']) ?>" class="sg-card p-6 hover:border-accent/30 transition group">
            <span class="text-accent font-mono text-[10px] uppercase tracking-widest">← Previous Insight</span>
            <p class="font-heading text-2xl mt-2 group-hover:text-accent transition-colors"><?= e($nav['prev']['title']) ?></p>
        </a>
        <?php endif; ?>
        <?php if ($nav['next'] ?? null): ?>
        <a href="<?= base_url('blog/' . $nav['next']['slug']) ?>" class="sg-card p-6 hover:border-accent/30 transition group text-right <?= !($nav['prev'] ?? null) ? 'md:col-start-2' : '' ?>">
            <span class="text-accent font-mono text-[10px] uppercase tracking-widest">Next Insight →</span>
            <p class="font-heading text-2xl mt-2 group-hover:text-accent transition-colors"><?= e($nav['next']['title']) ?></p>
        </a>
        <?php endif; ?>
    </nav>
</article>

<?php if (!empty($related)): ?>
<section class="px-6 py-20 bg-white/[0.02] border-y border-white/5">
    <div class="max-w-4xl mx-auto">
        <h2 class="font-heading text-3xl mb-12">Related <span class="text-accent">Expertise</span></h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($related as $r): ?>
            <a href="<?= base_url('blog/' . $r['slug']) ?>" class="sg-card group overflow-hidden">
                <div class="p-6">
                    <span class="text-accent font-mono text-[10px] uppercase tracking-widest mb-4 block">Case Study</span>
                    <h3 class="font-heading text-xl group-hover:text-accent transition-colors leading-snug"><?= e($r['title']) ?></h3>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="px-6 py-20">
    <div class="max-w-4xl mx-auto sg-card p-12 text-center relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5 text-9xl font-heading">GROW</div>
        <h2 class="font-heading text-4xl mb-4 relative z-10">Ready to Elevate Your Search <span>Presence</span>?</h2>
        <p class="text-textMuted text-lg mb-8 max-w-xl mx-auto relative z-10">Let's craft a technical SEO strategy that turns your website into a growth engine.</p>
        <a href="<?= base_url('contact.php') ?>" class="sg-btn-primary relative z-10">Get Expert SEO Consultation</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
