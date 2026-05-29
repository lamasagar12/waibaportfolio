</main>
<footer class="relative z-10 border-t border-white/5 bg-secondary/80 mt-20">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h3 class="font-heading font-bold text-2xl mb-3">Sagar <span class="text-accent">Waiba</span></h3>
            <p class="text-textMuted text-sm leading-relaxed mb-4">Building search visibility through strategy, data, and execution.</p>
            <p class="text-accent text-xs font-mono uppercase tracking-widest">SEO Specialist · Kathmandu, Nepal</p>
        </div>
        <div>
            <h4 class="font-semibold mb-3 text-accent">Quick Links</h4>
            <ul class="space-y-2 text-sm text-textSecondary">
                <li><a href="<?= base_url('about.php') ?>" class="hover:text-accent transition">About</a></li>
                <li><a href="<?= base_url('projects.php') ?>" class="hover:text-accent transition">Projects</a></li>
                <li><a href="<?= base_url('blog.php') ?>" class="hover:text-accent transition">Blog</a></li>
                <li><a href="<?= base_url('contact.php') ?>" class="hover:text-accent transition">Contact</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3 text-accent">Connect</h4>
            <p class="text-textSecondary text-sm">Ready to grow your organic traffic?</p>
            <a href="<?= base_url('contact.php') ?>" class="inline-block mt-4 sg-btn-primary text-sm">Get SEO Consultation</a>
        </div>
    </div>
    <div class="border-t border-white/5 py-4 text-center text-textMuted text-xs">
        &copy; <?= date('Y') ?> Sagar Waiba. All rights reserved.
    </div>
</footer>
<?php if (!empty($meta['global']['custom_body_scripts'])) echo $meta['global']['custom_body_scripts']; ?>
<script src="<?= asset_url('js/main.js') ?>"></script>
</body>
</html>
