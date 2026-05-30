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
                    <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center text-accent shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">Location</h4>
                        <p class="text-textMuted font-sans">Suryabinayak-8, Bhaktapur, Nepal</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center text-accent shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">Phone</h4>
                        <p class="text-textMuted font-sans">+977 9860463468</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center text-accent shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">Email</h4>
                        <p class="text-textMuted font-sans">waiba223sagar@gmail.com</p>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-white/5">
                <h4 class="font-heading text-xl mb-4">Connect Socially</h4>
                <div class="flex flex-wrap gap-3">
                    <a href="https://www.linkedin.com/in/sagar-tamang-waiba/" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300" title="LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.454C23.205 24 24 23.227 24 22.271V1.729C24 .774 23.205 0 22.225 0z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/lamasagar.waiba/" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300" title="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://www.instagram.com/sagar_yba/" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300" title="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.981 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="https://wa.me/9779860463468" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-accent hover:bg-accent hover:text-primary transition-all duration-300" title="WhatsApp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.407 3.481 2.241 2.242 3.477 5.23 3.476 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.942-.001-3.841-.481-5.53-1.393l-6.453 1.608zm6.736-4.398l.38.225c1.517.898 3.288 1.372 5.092 1.373 5.4 0 9.794-4.394 9.797-9.794.002-2.617-1.018-5.077-2.87-6.93s-4.314-2.873-6.931-2.873c-5.4 0-9.794 4.394-9.797 9.794-.001 1.884.534 3.714 1.549 5.293l.247.387-1.012 3.693 3.784-.943zm10.744-6.38c-.287-.144-1.697-.838-1.959-.933-.262-.095-.452-.144-.643.144-.191.288-.739.933-.906 1.121-.167.188-.334.212-.62.068s-1.208-.445-2.302-1.422c-.85-.758-1.423-1.693-1.59-1.98-.167-.288-.018-.443.126-.586.13-.129.287-.335.43-.503.143-.168.191-.288.287-.481.095-.192.048-.361-.024-.504s-.643-1.547-.882-2.122c-.232-.559-.467-.482-.643-.491-.166-.008-.357-.01-.548-.01s-.5-.072-.763.212c-.262.288-1.001.979-1.001 2.388s1.025 2.771 1.168 2.964c.143.192 2.017 3.08 4.885 4.318.682.295 1.214.471 1.629.603.685.217 1.309.186 1.802.112.55-.083 1.697-.693 1.936-1.362.239-.669.239-1.242.167-1.362-.072-.12-.262-.192-.549-.337z"/></svg>
                    </a>
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

    <!-- Map Section -->
    <div class="max-w-5xl mx-auto mt-16 animate-on-scroll">
        <div class="sg-card overflow-hidden h-[450px]">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3533.1970616165117!2d85.33761667492207!3d27.6803036266847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb190830a8087f%3A0x52cd412a5f64023f!2sDigital%20Terai%20-%20Digital%20Marketing%20Agency%20Nepal!5e0!3m2!1sen!2snp!4v1780159462081!5m2!1sen!2snp" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
