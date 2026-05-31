<?php /** @var array|null $post */ /** @var array $seoCheck */ ?>
<style>
    .ck-editor__editable { min-height: 400px; color: #000 !important; }
    .ck.ck-editor__main>.ck-editor__editable { background: #fff !important; }
    .ck.ck-toolbar { background: #f8f9fa !important; border-color: #ddd !important; }
</style>
<form method="POST" enctype="multipart/form-data" id="blog-form">
    <?= CSRF::field() ?>
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-6">
            <div class="sg-card p-6 space-y-4">
                <h3 class="font-heading font-bold text-accent">Content</h3>
                <div><label class="sg-form-label">Blog Title</label><input name="title" id="blog_title" value="<?= e($post['title'] ?? '') ?>" required class="sg-form-input"></div>
                <div><label class="sg-form-label">Slug</label><input name="slug" id="blog_slug" value="<?= e($post['slug'] ?? '') ?>" data-slug-from="#blog_title" class="sg-form-input"></div>
                <div><label class="sg-form-label">Excerpt</label><textarea name="excerpt" rows="2" class="sg-form-input"><?= e($post['excerpt'] ?? '') ?></textarea></div>
                <div><label class="sg-form-label">Content</label><textarea name="content" id="editor"><?= e($post['content'] ?? '') ?></textarea></div>
            </div>

            <div class="sg-card p-6 space-y-4">
                <h3 class="font-heading font-bold text-accent">SEO Settings</h3>
                <div><label class="sg-form-label">Meta Title</label><input name="meta_title" id="blog_meta_title" value="<?= e($post['meta_title'] ?? '') ?>" class="sg-form-input"><span data-char-counter="#blog_meta_title" data-min="30" data-max="60" class="sg-char-counter text-xs"></span></div>
                <div><label class="sg-form-label">Meta Description</label><textarea name="meta_description" id="blog_meta_description" rows="2" class="sg-form-input"><?= e($post['meta_description'] ?? '') ?></textarea><span data-char-counter="#blog_meta_description" data-min="120" data-max="160" class="sg-char-counter text-xs"></span></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="sg-form-label">Focus Keyword</label><input name="focus_keyword" value="<?= e($post['focus_keyword'] ?? '') ?>" class="sg-form-input"></div>
                    <div><label class="sg-form-label">Secondary Keywords</label><input name="secondary_keywords" value="<?= e($post['secondary_keywords'] ?? '') ?>" class="sg-form-input"></div>
                    <div><label class="sg-form-label">LSI Keywords</label><input name="lsi_keywords" value="<?= e($post['lsi_keywords'] ?? '') ?>" class="sg-form-input"></div>
                    <div><label class="sg-form-label">Canonical URL</label><input name="canonical_url" value="<?= e($post['canonical_url'] ?? '') ?>" class="sg-form-input"></div>
                </div>
                <?php sg_seo_preview('blog', base_url('blog/')); ?>
            </div>

            <div class="sg-card p-6 space-y-4">
                <h3 class="font-heading font-bold text-accent">Anchor Text Manager</h3>
                <div id="anchor-rows" class="space-y-3">
                    <?php if (empty($anchors)): $anchors = [['anchor_text'=>'','target_url'=>'','link_type'=>'internal','rel_attribute'=>'follow','location_hint'=>'']]; endif;
                    foreach ($anchors as $i => $a): ?>
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-2 items-end border-b border-white/5 pb-3">
                        <div><label class="sg-form-label">Anchor Text</label><input name="anchor_text[]" value="<?= e($a['anchor_text']) ?>" class="sg-form-input"></div>
                        <div><label class="sg-form-label">Target URL</label><input name="anchor_url[]" value="<?= e($a['target_url']) ?>" class="sg-form-input"></div>
                        <div><label class="sg-form-label">Type</label><select name="anchor_type[]" class="sg-form-input"><option value="internal" <?= ($a['link_type']??'')==='internal'?'selected':'' ?>>Internal</option><option value="external" <?= ($a['link_type']??'')==='external'?'selected':'' ?>>External</option></select></div>
                        <div><label class="sg-form-label">Rel</label><select name="anchor_rel[]" class="sg-form-input"><option value="follow">follow</option><option value="nofollow" <?= ($a['rel_attribute']??'')==='nofollow'?'selected':'' ?>>nofollow</option><option value="sponsored">sponsored</option><option value="ugc">ugc</option></select></div>
                        <div><label class="sg-form-label">Location</label><input name="anchor_location[]" value="<?= e($a['location_hint'] ?? '') ?>" class="sg-form-input"></div>
                        <div><label class="flex items-center gap-1 text-xs"><input type="checkbox" name="anchor_newtab[<?= $i ?>]" value="1" <?= !empty($a['open_new_tab'])?'checked':'' ?>> New tab</label></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addAnchorRow()" class="sg-btn-outline text-xs">+ Add Link</button>
            </div>

            <div class="sg-card p-6 space-y-4">
                <h3 class="font-heading font-bold text-accent">FAQ Schema</h3>
                <div id="faq-rows" class="space-y-3">
                    <?php if (empty($faqs)): $faqs = [['question'=>'','answer'=>'']]; endif;
                    foreach ($faqs as $faq): ?>
                    <div class="space-y-2 border-b border-white/5 pb-3">
                        <input name="faq_question[]" value="<?= e($faq['question']) ?>" placeholder="Question" class="sg-form-input">
                        <textarea name="faq_answer[]" rows="2" placeholder="Answer" class="sg-form-input"><?= e($faq['answer']) ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addFaqRow()" class="sg-btn-outline text-xs">+ Add FAQ</button>
            </div>
        </div>

        <div class="space-y-6">
            <div class="sg-card p-5 space-y-4">
                <h3 class="font-heading font-bold text-accent">Publish</h3>
                <div><label class="sg-form-label">Status</label><select name="status" class="sg-form-input"><option value="draft" <?= ($post['status']??'draft')==='draft'?'selected':'' ?>>Draft</option><option value="published" <?= ($post['status']??'')==='published'?'selected':'' ?>>Published</option><option value="scheduled" <?= ($post['status']??'')==='scheduled'?'selected':'' ?>>Scheduled</option></select></div>
                <div><label class="sg-form-label">Publish Date</label><input type="datetime-local" name="publish_date" value="<?= $post['publish_date'] ? date('Y-m-d\TH:i', strtotime($post['publish_date'])) : '' ?>" class="sg-form-input"></div>
                <div><label class="sg-form-label">Category</label><select name="category_id" class="sg-form-input"><option value="">— Select —</option><?php foreach ($categories as $c): ?><option value="<?= $c['id'] ?>" <?= ($post['category_id']??'')==$c['id']?'selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
                <div><label class="sg-form-label">Author</label><input name="author_name" value="<?= e($post['author_name'] ?? Auth::user()['name']) ?>" class="sg-form-input"></div>
                <div><label class="sg-form-label">Tags</label>
                    <select name="tags[]" multiple class="sg-form-input h-24"><?php foreach ($tags as $t): ?><option value="<?= $t['id'] ?>" <?= in_array($t['id'], $selectedTags)?'selected':'' ?>><?= e($t['name']) ?></option><?php endforeach; ?></select>
                </div>
                <button type="submit" class="sg-btn-primary w-full">Save Post</button>
            </div>

            <div class="sg-card p-5 space-y-4">
                <h3 class="font-heading font-bold text-accent">Featured Image</h3>
                <p class="text-textMuted text-xs">Recommended: 1200×630px (WebP/JPG)</p>
                <?php if (!empty($post['featured_image_url'])): ?>
                <img src="<?= e($post['featured_image_url']) ?>" class="w-full rounded-lg mb-2" alt="">
                <input type="hidden" name="featured_image_id" value="<?= $post['featured_image_id'] ?>">
                <?php endif; ?>
                <input type="file" name="featured_image" accept="image/*" class="sg-form-input">
                <input name="featured_image_alt" value="<?= e($post['featured_image_alt'] ?? '') ?>" placeholder="Alt text *" class="sg-form-input">
                <input name="featured_image_title" value="<?= e($post['featured_image_title'] ?? '') ?>" placeholder="Image title" class="sg-form-input">
                <input name="featured_image_caption" value="<?= e($post['featured_image_caption'] ?? '') ?>" placeholder="Caption" class="sg-form-input">
            </div>

            <?php if (!empty($seoCheck)): ?>
            <div class="sg-card p-5">
                <h3 class="font-heading font-bold text-accent mb-3">SEO Score: <span class="<?= seo_score_badge_class($seoCheck['score']) ?> sg-badge"><?= $seoCheck['score'] ?>%</span></h3>
                <ul class="space-y-1 text-xs">
                    <?php
                    $labels = [
                        'focus_in_title'=>'Focus keyword in title','focus_in_desc'=>'Focus keyword in description',
                        'focus_in_slug'=>'Focus keyword in slug','focus_in_first_para'=>'Focus keyword in first paragraph',
                        'focus_in_h2'=>'Focus keyword in H2','meta_title_length'=>'Meta title length (30-60)',
                        'meta_desc_length'=>'Meta description length (120-160)','featured_image'=>'Featured image added',
                        'featured_alt'=>'Featured image alt text','internal_links'=>'Internal links added',
                        'external_links'=>'External links added','word_count'=>'600+ words',
                        'heading_structure'=>'Proper H2/H3 structure','schema_enabled'=>'Schema enabled',
                    ];
                    foreach ($seoCheck['checks'] as $key => $pass): ?>
                    <li class="flex items-center gap-2 <?= $pass ? 'text-green-400' : 'text-textMuted' ?>">
                        <?php if ($pass): ?>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <?php else: ?>
                            <svg class="w-3.5 h-3.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"></circle></svg>
                        <?php endif; ?>
                        <?= $labels[$key] ?? $key ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/4.17.1/standard-all/ckeditor.js"></script>
<script>
CKEDITOR.replace('editor', {
    extraPlugins: 'embed,autoembed,image2,codesnippet,justify,colorbutton,panelbutton,font',
    height: 400,
    // Add custom configuration here if needed
    contentsCss: [
        'https://cdn.ckeditor.com/4.17.1/standard-all/contents.css'
    ],
    // Setup for dark mode appearance if possible, or just standard
    uiColor: '#f8f9fa',
    format_tags: 'p;h2;h3;h4;pre',
    removeButtons: 'About',
});

function addAnchorRow() {
    const html = `<div class="grid grid-cols-2 md:grid-cols-6 gap-2 items-end border-b border-white/5 pb-3">
        <div><label class="sg-form-label">Anchor Text</label><input name="anchor_text[]" class="sg-form-input"></div>
        <div><label class="sg-form-label">Target URL</label><input name="anchor_url[]" class="sg-form-input"></div>
        <div><label class="sg-form-label">Type</label><select name="anchor_type[]" class="sg-form-input"><option value="internal">Internal</option><option value="external">External</option></select></div>
        <div><label class="sg-form-label">Rel</label><select name="anchor_rel[]" class="sg-form-input"><option value="follow">follow</option><option value="nofollow">nofollow</option><option value="sponsored">sponsored</option><option value="ugc">ugc</option></select></div>
        <div><label class="sg-form-label">Location</label><input name="anchor_location[]" class="sg-form-input"></div>
        <div></div></div>`;
    document.getElementById('anchor-rows').insertAdjacentHTML('beforeend', html);
}
function addFaqRow() {
    document.getElementById('faq-rows').insertAdjacentHTML('beforeend',
        `<div class="space-y-2 border-b border-white/5 pb-3"><input name="faq_question[]" placeholder="Question" class="sg-form-input"><textarea name="faq_answer[]" rows="2" placeholder="Answer" class="sg-form-input"></textarea></div>`);
}
</script>
