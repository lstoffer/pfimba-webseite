<?php snippet('header') ?>

<h1><?= $page->title() ?></h1>

<?php
    $anlaesse = $page->aktivitaeten()->toBlocks()
        ->filterBy('type', 'anlass')
        ->filter(fn ($block) => $block->name()->isNotEmpty() && $block->datum()->isNotEmpty())
        ->sortBy(fn ($block) => $block->datum()->toDate(), 'asc');
?>

<?php if ($anlaesse->isNotEmpty()): ?>

    <div class="content one">
        <?php foreach ($anlaesse as $block): ?>
            <?= $block->toHtml() ?>
        <?php endforeach ?>
    </div>

<?php else: ?>

    <p>Noch keine Anlässe vorhanden.</p>

<?php endif ?>

<?php snippet('footer') ?>
