<?php snippet('header') ?>

<h1><?= $page->title() ?></h1>

<?php
    $blocks = $page->dokumente()->toBlocks()->filterBy('type', 'archiv_dokument');

    $usedJahre = [];

    foreach ($blocks as $block) {
        $jahr = $block->jahr()->toDate('Y');

        if ($jahr) {
            $usedJahre[$jahr] = true;
        }
    }

    $usedJahre = array_keys($usedJahre);
    rsort($usedJahre);
?>

<?php if ($blocks->isNotEmpty()): ?>

    <?php if (count($usedJahre) > 1): ?>
        <div class="galerie-filter" id="galerie-filter">
            <div class="galerie-filter-group">
                <span id="galerie-filter-jahr-label">Jahr</span>
                <div class="galerie-select" id="galerie-filter-jahr">
                    <button
                        type="button"
                        class="galerie-select-trigger"
                        id="galerie-filter-jahr-trigger"
                        aria-haspopup="listbox"
                        aria-expanded="false"
                        aria-labelledby="galerie-filter-jahr-label galerie-filter-jahr-trigger"
                    >
                        <span class="galerie-select-value">Alle Jahre</span>
                    </button>
                    <ul class="galerie-select-options" role="listbox" tabindex="-1" aria-labelledby="galerie-filter-jahr-label" hidden>
                        <li role="option" aria-selected="true" class="galerie-select-option selected" data-value="all">Alle Jahre</li>
                        <?php foreach ($usedJahre as $jahr): ?>
                            <li role="option" aria-selected="false" class="galerie-select-option" data-value="<?= esc($jahr) ?>"><?= esc($jahr) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div class="archiv-grid" id="galerie-grid">
        <?php foreach ($blocks as $block): ?>
            <?= $block->toHtml() ?>
        <?php endforeach ?>
    </div>

    <p class="galerie-empty" id="galerie-empty" hidden>Keine Einträge für diese Auswahl gefunden.</p>

<?php endif ?>

<?php snippet('footer') ?>
