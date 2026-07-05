<?php snippet('header') ?>

<h1><?= $page->title() ?></h1>

<?php
    $anlaesse = $page->aktivitaeten()->toBlocks()
        ->filterBy('type', 'anlass')
        ->filter(fn ($block) => $block->name()->isNotEmpty() && $block->datum()->isNotEmpty())
        ->sortBy(fn ($block) => $block->datum()->toDate(), 'asc');

    $anlaesseByYear = $anlaesse->group(fn ($block) => $block->datum()->toDate('Y'));
?>

<?php foreach ($anlaesseByYear as $jahr => $anlaesseDesJahres): ?>
    <div class="jahresprogramm-jahr">
        <h2 class="jahresprogramm-jahr-titel"><?= esc($jahr) ?></h2>
        <div class="content one">
            <?php foreach ($anlaesseDesJahres as $block): ?>
                <?= $block->toHtml() ?>
            <?php endforeach ?>
        </div>
    </div>
<?php endforeach ?>

<?php snippet('footer') ?>
