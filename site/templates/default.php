<?php snippet('header') ?>

<h1><?= $page->title() ?></h1>

<?php
    $nextAnlass = null;

    if ($page->isHomePage()) {
        $jahresprogramm = page('page://mvq5nyzsti0nrqsu');

        if ($jahresprogramm) {
            $nextAnlass = $jahresprogramm->aktivitaeten()->toBlocks()
                ->filterBy('type', 'anlass')
                ->filter(fn ($block) => $block->name()->isNotEmpty() && $block->datum()->isNotEmpty())
                ->filter(fn ($block) => $block->datum()->toDate() >= strtotime('today'))
                ->sortBy(fn ($block) => $block->datum()->toDate(), 'asc')
                ->first();
        }
    }

    $nextAnlassPosition = $page->naechsterAnlassPosition()->value() ?: 'unten';
?>

<?php if ($nextAnlass && $nextAnlassPosition === 'oben'): ?>
    <div class="naechster-anlass">
        <h2 class="naechster-anlass-title">Nächster Anlass</h2>
        <?= $nextAnlass->toHtml() ?>
    </div>
<?php endif ?>

<?= $page->inhaltselemente()->toBlocks() ?>

<?php if ($nextAnlass && $nextAnlassPosition !== 'oben'): ?>
    <div class="naechster-anlass">
        <h2 class="naechster-anlass-title">Nächster Anlass</h2>
        <?= $nextAnlass->toHtml() ?>
    </div>
<?php endif ?>

<?php snippet('footer') ?>
