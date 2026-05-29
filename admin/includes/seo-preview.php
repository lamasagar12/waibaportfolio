<?php
function sg_seo_preview(string $prefix, string $baseUrl = ''): void { ?>
<input type="hidden" id="sg-base-url" value="<?= e($baseUrl ?: base_url()) ?>">
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
    <div class="sg-card p-4">
        <h4 class="text-xs font-semibold text-accent mb-2 uppercase">Google Preview</h4>
        <div class="sg-seo-preview">
            <div class="title" id="<?= $prefix ?>-google-title">Page Title</div>
            <div class="url" id="<?= $prefix ?>-google-url"><?= e($baseUrl ?: base_url()) ?></div>
            <div class="desc" id="<?= $prefix ?>-google-desc">Meta description preview...</div>
        </div>
    </div>
    <div class="sg-card p-4">
        <h4 class="text-xs font-semibold text-accent mb-2 uppercase">Facebook Preview</h4>
        <div class="bg-[#f0f2f5] rounded p-3 text-sm">
            <div class="bg-gray-300 h-24 rounded mb-2 flex items-center justify-center text-gray-500 text-xs">OG Image</div>
            <div class="font-semibold text-gray-900 text-xs" id="<?= $prefix ?>-fb-title">OG Title</div>
            <div class="text-gray-500 text-xs mt-1" id="<?= $prefix ?>-fb-desc">OG Description</div>
        </div>
    </div>
    <div class="sg-card p-4">
        <h4 class="text-xs font-semibold text-accent mb-2 uppercase">Twitter Preview</h4>
        <div class="bg-[#15202b] rounded p-3 text-sm">
            <div class="bg-gray-700 h-24 rounded mb-2 flex items-center justify-center text-gray-400 text-xs">Twitter Image</div>
            <div class="font-semibold text-white text-xs" id="<?= $prefix ?>-tw-title">Twitter Title</div>
            <div class="text-gray-400 text-xs mt-1" id="<?= $prefix ?>-tw-desc">Twitter Description</div>
        </div>
    </div>
</div>
<script>
['meta_title','meta_description','slug','title'].forEach(f => {
    document.getElementById('<?= $prefix ?>_' + f)?.addEventListener('input', () => sgSeoPreview('<?= $prefix ?>'));
});
sgSeoPreview('<?= $prefix ?>');
</script>
<?php }
