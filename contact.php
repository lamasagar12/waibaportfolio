<?php
$page_key = 'contact';
require_once 'includes/header.php';
require_once 'includes/page-helpers.php';
$success = flash('success');
sg_page_hero('Get in <span>Touch</span>', 'Ready to grow your organic traffic? Let\'s talk.');
?>
<section class="px-6 pb-20">
    <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Contact Info -->
        <div class="space-y-8 animate-on-scroll">
            <div>
                <h3 class="text-accent font-heading font-bold text-2xl mb-4">Contact Information</h3>
                <p class="text-textSecondary leading-relaxed">Feel free to reach out for SEO consultations, project inquiries, or just to say hi!</p>
            </div>

            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center text-accent shrink-0">📍</div>
                    <div>
                        <h4 class="font-bold text-lg">Location</h4>
                        <p class="text-textMuted font-sans">Suryabinayak-8, Bhaktapur, Nepal</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center text-accent shrink-0">📞</div>
                    <div>
                        <h4 class="font-bold text-lg">Phone</h4>
                        <p class="text-textMuted font-sans">+977 9860463468</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center text-accent shrink-0">✉️</div>
                    <div>
                        <h4 class="font-bold text-lg">Email</h4>
                        <p class="text-textMuted font-sans">waiba223sagar@gmail.com</p>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-white/5">
                <h4 class="font-heading text-xl mb-4">Connect Socially</h4>
                <div class="flex flex-wrap gap-3">
                    <a href="https://www.linkedin.com/in/sagar-tamang-waiba/" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300">Li</a>
                    <a href="https://www.facebook.com/lamasagar.waiba/" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300">Fb</a>
                    <a href="https://www.instagram.com/sagar_yba/" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300">Ig</a>
                    <a href="https://wa.me/9779860463468" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300">Wa</a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="sg-card p-8 animate-on-scroll">
            <h3 class="font-heading text-2xl mb-6">Let's <span>Talk</span></h3>
            <?php if ($success): ?><div class="bg-green-500/10 border border-green-500/30 text-green-400 p-3 rounded-lg mb-4 text-sm"><?= e($success) ?></div><?php endif; ?>
            <form method="POST" action="mailto:waiba223sagar@gmail.com" enctype="text/plain" class="space-y-4">
                <div><label class="sg-form-label">Name</label><input type="text" name="name" required class="sg-form-input"></div>
                <div><label class="sg-form-label">Email</label><input type="email" name="email" required class="sg-form-input"></div>
                <div><label class="sg-form-label">Subject</label><input type="text" name="subject" required class="sg-form-input"></div>
                <div><label class="sg-form-label">Message</label><textarea name="message" rows="5" required class="sg-form-input"></textarea></div>
                <button type="submit" class="sg-btn-primary w-full">Send Message</button>
            </form>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
