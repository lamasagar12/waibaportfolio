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
                <span class="text-textMuted text-2xl md:text-1xl font-mono tracking-tight">Project Manager · Team Lead · SEO Strategist</span>
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
        <p class="text-textSecondary text-center mb-12 max-w-2xl mx-auto font-sans text-base">Comprehensive SEO and digital growth solutions tailored to improve rankings, increase organic traffic, and generate quality leads.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $services = [
                ['Website Audits', 'Comprehensive analysis of site health, performance, and ranking factors.', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>'],
                ['Keyword Research', 'Identifying high-intent keywords to target qualified traffic and customers.', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>'],
                ['On-page SEO', 'Optimizing content, meta tags, and headers for maximum search relevance.', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>'],
                ['Technical SEO', 'Core Web Vitals, site speed, indexing, and schema markup optimization.', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>'],
                ['Local SEO', 'Driving foot traffic and local leads through regional search dominance.', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>'],
                ['Content Strategy', 'Creating data-driven content roadmaps that convert readers into leads.', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>'],
                ['Link Building', 'Building authority through high-quality, niche-relevant backlink campaigns.', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>'],
                ['Project Management', 'Coordinating complex SEO workflows and ensuring timely delivery of milestones.', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>'],
                ['Team Leadership', 'Mentoring SEO specialists and leading cross-functional teams for success.', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'],
            ];
            foreach ($services as [$title, $desc, $icon]): ?>
            <div class="sg-card p-6 animate-on-scroll border-t-2 border-t-transparent hover:border-t-accent transition-all duration-500">
                <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center text-accent mb-4"><?= $icon ?></div>
                <h3 class="font-heading font-bold text-2xl mb-2 tracking-wide"><?= $title ?></h3>
                <p class="text-textMuted text-sm font-sans leading-relaxed text-base"><?= $desc ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="px-6 py-20 bg-white/[0.02]">
    <div class="max-w-7xl mx-auto">
        <h2 class="sg-section-title text-center mb-4">SEO Results & <span>Case Studies</span></h2>
        <p class="text-textSecondary text-center mb-12 max-w-2xl mx-auto text-base">Measurable growth and strategic success stories from diverse industries.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php
            $cases = [
                ['A One Jetski Dubai', 'Local SEO, GBP optimization, and travel SEO strategy.', 'https://aonejetski.com'],
                ['888 Realty Canada', 'Technical SEO audit and keyword mapping.', 'https://888realty.ca'],
                ['Nepal Moto Tours', 'Travel SEO content strategy and audit.', 'https://nepalmototours.com'],
                ['Digital Terai Projects', 'SEO campaign management, reporting, and backlink planning.', 'https://digitalterai.com.np']
            ];
            foreach ($cases as [$title, $desc, $url]): ?>
            <div class="sg-card p-0 overflow-hidden group animate-on-scroll">
                <div class="flex flex-col md:flex-row h-full">
                    <div class="md:w-2/5 relative overflow-hidden bg-tertiary">
                        <img src="https://unavatar.io/microlink/<?= urlencode($url) ?>?fallback=https://s.wordpress.com/mshots/v1/<?= urlencode($url) ?>?w=600" alt="<?= $title ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    </div>
                    <div class="p-8 md:w-3/5 flex flex-col justify-center">
                        <span class="text-accent font-mono text-[10px] uppercase tracking-[0.2em] mb-3 block">Success Story</span>
                        <h3 class="font-heading text-3xl mb-3 group-hover:text-accent transition-colors"><?= $title ?></h3>
                        <p class="text-textMuted text-base leading-relaxed mb-6"><?= $desc ?></p>
                        <a href="<?= base_url('projects.php') ?>" class="text-accent text-sm font-bold uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">View Details <span>→</span></a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="px-6 py-20">
    <div class="max-w-7xl mx-auto">
        <h2 class="sg-section-title text-center mb-12">Tools <span>I Use</span></h2>
        <div class="flex flex-wrap justify-center gap-4 animate-on-scroll">
            <?php
            $tools = ['Google Search Console', 'Google Analytics 4', 'Google Tag Manager', 'SEMrush', 'Ahrefs', 'Screaming Frog', 'Microsoft Clarity', 'WordPress', 'Google Business Profile'];
            foreach ($tools as $tool): ?>
            <div class="px-6 py-3 rounded-xl bg-white/5 border border-white/10 text-textSecondary text-sm font-mono hover:border-accent/40 hover:text-accent transition-all duration-300">
                <?= $tool ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="px-6 py-20 bg-secondary/50">
    <div class="max-w-7xl mx-auto text-center">
        <h2 class="sg-section-title mb-4">Latest from the <span>Blog</span></h2>
        <p class="text-textSecondary mb-12 text-base">SEO insights, strategies, and digital growth tips.</p>
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
                        <h3 class="font-heading font-bold mt-2 mb-2 tracking-[0.025em] md:tracking-[0.04em] leading-[1.35]"><a href="<?= base_url('blog/' . $post['slug']) ?>" class="hover:text-accent transition"><?= e($post['title']) ?></a></h3>
                        <p class="text-textSecondary text-base line-clamp-2"><?= e($post['excerpt']) ?></p>
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
    <div class="max-w-4xl mx-auto text-center sg-card p-16 animate-on-scroll relative overflow-hidden border-accent/20">
        <div class="absolute inset-0 bg-accent/5 blur-3xl rounded-full -z-10 translate-y-1/2"></div>
        <h2 class="sg-section-title mb-6">Ready to Scale Your <span>Organic Growth?</span></h2>
        <p class="text-textSecondary mb-10 text-lg max-w-2xl mx-auto leading-relaxed">Let's build a data-backed SEO strategy that drives high-quality leads and sustainable revenue for your business.</p>
        <a href="<?= base_url('contact.php') ?>" class="sg-btn-primary scale-110">Book Free SEO Consultation</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
