<?php snippet('header') ?>

<h1><?= $page->title() ?></h1>

<?php
    $nextAnlass = null;

    if ($page->isHomePage()) {
        $jahresprogramm = page('page://mvq5nyzsti0nrqsu');

        if ($jahresprogramm) {
            $anlaesse = array_filter(
                pfimbaCollectAnlassBlocks($jahresprogramm->aktivitaeten()->toBlocks()),
                function ($block) {
                    if ($block->name()->isEmpty() || $block->datum()->isEmpty()) {
                        return false;
                    }

                    $ende = $block->mehrtaegig()->toBool() && $block->enddatum()->isNotEmpty()
                        ? $block->enddatum()->toDate()
                        : $block->datum()->toDate();

                    return $ende >= strtotime('today');
                }
            );

            usort($anlaesse, fn ($a, $b) => $a->datum()->toDate() <=> $b->datum()->toDate());

            $nextAnlass = $anlaesse[0] ?? null;
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
