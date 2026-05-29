<?php
$page_key = 'about';
require_once 'includes/header.php';
require_once 'includes/page-helpers.php';
sg_page_hero('SEO-Driven. <span>Results-Focused.</span>', 'Building search visibility through strategy, data, and execution.');
?>
<section class="px-6 pb-20">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
            <div class="animate-on-scroll">
                <div class="relative group">
                    <div class="absolute -inset-2 bg-gradient-to-r from-accent to-accentDark rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <img src="<?= asset_url('images/profile.png') ?>" alt="Sagar Waiba" class="relative rounded-2xl ring-1 ring-borderAmber shadow-glow w-full max-w-md mx-auto">
                </div>
            </div>
            <div class="animate-on-scroll">
                <h2 class="font-heading text-4xl mb-6">Hi, I'm <span class="text-accent">Sagar Waiba</span></h2>
                <div class="space-y-4 text-textMuted leading-relaxed font-sans text-lg">
                    <p>I'm Sagar Waiba, an SEO Specialist and Digital Marketing Strategist based in Kathmandu, Nepal. With hands-on SEO experience, I work with national and international clients to build organic growth through strategic planning, technical precision, and measurable execution.</p>
                    <p>My expertise covers keyword research, on-page SEO, technical SEO audits, structured data, Google Business Profile optimization, reporting, CRO-focused content, and high-quality link building.</p>
                    <p>I use tools like GA4, Google Search Console, Google Tag Manager, Microsoft Clarity, Semrush, Ahrefs, Screaming Frog, Looker Studio, and WordPress to turn data into action and action into rankings.</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="sg-card p-4 border-l-2 border-l-accent">
                        <div class="text-2xl font-heading text-accent">2+ Years</div>
                        <div class="text-xs font-mono uppercase tracking-wider text-textMuted">SEO Experience</div>
                    </div>
                    <div class="sg-card p-4 border-l-2 border-l-accent">
                        <div class="text-2xl font-heading text-accent">Global</div>
                        <div class="text-xs font-mono uppercase tracking-wider text-textMuted">National & International</div>
                    </div>
                    <div class="sg-card p-4 border-l-2 border-l-accent">
                        <div class="text-2xl font-heading text-accent">Expertise</div>
                        <div class="text-xs font-mono uppercase tracking-wider text-textMuted">Technical & Link Building</div>
                    </div>
                    <div class="sg-card p-4 border-l-2 border-l-accent">
                        <div class="text-2xl font-heading text-accent">Local SEO</div>
                        <div class="text-xs font-mono uppercase tracking-wider text-textMuted">GBP Optimization</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto animate-on-scroll">
            <h3 class="font-heading text-3xl mb-8 text-center">Education</h3>
            <div class="sg-card p-8 border-t-2 border-t-accent relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 text-6xl">🎓</div>
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h4 class="text-xl font-bold text-textPrimary">Bachelor's in Information Management</h4>
                        <div class="text-accent font-medium">Bhaktapur Multiple Campus</div>
                        <div class="text-textMuted text-sm">Bhaktapur, Nepal</div>
                    </div>
                    <div class="text-right">
                        <div class="inline-block px-3 py-1 rounded-full bg-accent/10 border border-accent/20 text-accent text-xs font-mono">Jan 2020 – Jan 2025</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
