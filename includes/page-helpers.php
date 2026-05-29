<?php
function sg_page_hero(string $title, string $subtitle = ''): void { ?>
<section class="px-6 py-16 text-center">
    <div class="max-w-3xl mx-auto animate-on-scroll">
        <h1 class="sg-section-title mb-4"><?= $title ?></h1>
        <?php if ($subtitle): ?><p class="text-textSecondary text-lg"><?= $subtitle ?></p><?php endif; ?>
    </div>
</section>
<?php }
