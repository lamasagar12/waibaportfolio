<?php
$page_key = 'home';
require_once 'includes/header.php';
?>

<section class="relative min-h-[90vh] flex items-center px-6 overflow-hidden">
    <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="z-10 animate-on-scroll">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent/10 border border-accent/25 text-accent text-sm font-bold mb-6">
                <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span></span>
                Available for SEO Projects
            </div>
            <h1 class="font-heading text-6xl md:text-8xl font-normal leading-[0.9] mb-6">
                Hi, I'm <span class="text-accent">Sagar Waiba</span><br>
                <span class="text-textMuted text-2xl md:text-1xl font-mono tracking-tight">SEO Specialist · Link Builder · Digital Marketing Strategist</span>
            </h1>
            <p class="text-textMuted text-lg mb-8 max-w-xl leading-relaxed font-sans">
                I help businesses improve online visibility, grow organic traffic, strengthen search presence, and build SEO strategies that align with long-term business goals.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="<?= base_url('projects.php') ?>" class="sg-btn-primary">View My Work</a>
                <a href="https://www.linkedin.com/in/sagar-tamang-waiba/" target="_blank" class="sg-btn-outline">Connect on LinkedIn</a>
                <a href="<?= base_url('contact.php') ?>" class="sg-btn-outline">Contact Me</a>
            </div>
            <div class="grid grid-cols-3 gap-6 mt-12 border-t border-white/5 pt-8">
                <div><div class="text-4xl font-heading text-accent" data-counter="2" data-suffix="+">0</div><div class="text-textMuted text-xs font-mono uppercase tracking-widest mt-1">Years Exp</div></div>
                <div><div class="text-4xl font-heading text-accent" data-counter="8" data-suffix="+">0</div><div class="text-textMuted text-xs font-mono uppercase tracking-widest mt-1">Projects</div></div>
                <div><div class="text-4xl font-heading text-accent" data-counter="7" data-suffix="+">0</div><div class="text-textMuted text-xs font-mono uppercase tracking-widest mt-1">Certifications</div></div>
            </div>
        </div>
        <div class="relative flex justify-center animate-on-scroll">
            <!-- Infinite Orbital Glow Animation - Increased Visibility -->
            <div class="absolute top-1/2 left-1/2 w-48 h-48 md:w-64 md:h-64 bg-accent/40 rounded-full blur-[70px] animate-sg-orbit"></div>
            <div class="absolute top-1/2 left-1/2 w-36 h-36 md:w-48 md:h-48 bg-accentDark/50 rounded-full blur-[50px] animate-sg-orbit-slow"></div>
            <div class="absolute top-1/2 left-1/2 w-60 h-60 md:w-80 md:h-80 bg-accentLight/30 rounded-full blur-[90px] animate-sg-orbit" style="animation-duration: 20s; animation-delay: -5s;"></div>
            
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-accent to-accentDark rounded-full blur opacity-40 group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                <img src="<?= asset_url('images/profile.png') ?>" alt="Sagar Waiba - SEO Specialist" class="relative w-72 md:w-80 rounded-full ring-1 ring-borderAmber shadow-glow transition duration-500 group-hover:scale-[1.02]">
            </div>
        </div>
    </div>
</section>

<section class="px-6 py-20">
    <div class="max-w-7xl mx-auto">
        <h2 class="sg-section-title text-center mb-4">Core <span>Services</span></h2>
        <p class="text-textSecondary text-center mb-12 max-w-2xl mx-auto font-sans">Comprehensive SEO and digital growth solutions tailored to improve rankings, increase organic traffic, and generate quality leads.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $services = [
                ['Website Audits', 'Comprehensive analysis of site health, performance, and ranking factors.', '🔍'],
                ['Keyword Research', 'Identifying high-intent keywords to target qualified traffic and customers.', '🔑'],
                ['On-page SEO', 'Optimizing content, meta tags, and headers for maximum search relevance.', '📝'],
                ['Technical SEO', 'Core Web Vitals, site speed, indexing, and schema markup optimization.', '⚙️'],
                ['Local SEO', 'Driving foot traffic and local leads through regional search dominance.', '📍'],
                ['GBP Optimization', 'Managing Google Business Profile for maximum local map visibility.', '🏪'],
                ['Content Strategy', 'Creating data-driven content roadmaps that convert readers into leads.', '📊'],
                ['Link Building', 'Building authority through high-quality, niche-relevant backlink campaigns.', '🔗'],
                ['WordPress SEO', 'Platform-specific optimization for fast, secure, and rankable WP sites.', '🌐'],
            ];
            foreach ($services as [$title, $desc, $icon]): ?>
            <div class="sg-card p-6 animate-on-scroll border-t-2 border-t-transparent hover:border-t-accent transition-all duration-500">
                <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center text-accent text-xl mb-4"><?= $icon ?></div>
                <h3 class="font-heading font-bold text-2xl mb-2 tracking-wide"><?= $title ?></h3>
                <p class="text-textMuted text-sm font-sans leading-relaxed"><?= $desc ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="px-6 py-20 bg-secondary/50">
    <div class="max-w-7xl mx-auto text-center">
        <h2 class="sg-section-title mb-4">Latest from the <span>Blog</span></h2>
        <p class="text-textSecondary mb-12">SEO insights, strategies, and digital growth tips.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            try {
                $recent = BlogModel::all(['status' => 'published'], 1, 3);
                foreach ($recent['data'] as $post): ?>
                <article class="sg-card overflow-hidden text-left animate-on-scroll">
                    <?php if ($post['featured_image_url']): ?>
                    <img src="<?= e($post['featured_image_url']) ?>" alt="<?= e($post['featured_image_alt'] ?? $post['title']) ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                    <div class="w-full h-48 bg-tertiary flex items-center justify-center text-accent/30 text-4xl">📝</div>
                    <?php endif; ?>
                    <div class="p-5">
                        <span class="text-accent text-xs font-semibold"><?= e($post['category_name'] ?? 'Blog') ?></span>
                        <h3 class="font-heading font-bold mt-2 mb-2"><a href="<?= base_url('blog/' . $post['slug']) ?>" class="hover:text-accent transition"><?= e($post['title']) ?></a></h3>
                        <p class="text-textSecondary text-sm line-clamp-2"><?= e($post['excerpt']) ?></p>
                    </div>
                </article>
                <?php endforeach;
            } catch (Exception $e) { echo '<p class="text-textMuted col-span-3">Run install.php to enable blog features.</p>'; }
            ?>
        </div>
        <a href="<?= base_url('blog.php') ?>" class="inline-block mt-10 sg-btn-outline">View All Posts</a>
    </div>
</section>

<section class="px-6 py-20">
    <div class="max-w-3xl mx-auto text-center sg-card p-10 animate-on-scroll">
        <h2 class="sg-section-title mb-4">Ready to <span>Grow</span>?</h2>
        <p class="text-textSecondary mb-8">Let's build an SEO strategy that drives real organic traffic and revenue.</p>
        <a href="<?= base_url('contact.php') ?>" class="sg-btn-primary">Get Free SEO Consultation</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
