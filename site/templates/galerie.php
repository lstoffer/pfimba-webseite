<?php snippet('header') ?>

<h1><?= $page->title() ?></h1>

<?php
    $blocks = $page->bilder()->toBlocks()->filterBy('type', 'google_fotos');

    $stufenLabelMap = [
        'abteilung' => 'Abteilung',
        'biber'     => 'Biber',
        'woelfe'    => 'Wölfe',
        'pfadis'    => 'Pfadis',
        'pios'      => 'Pios',
        'rover'     => 'Rover',
        'elternrat' => 'Elternrat',
    ];

    $usedStufen = [];
    $usedJahre  = [];

    foreach ($blocks as $block) {
        foreach ($block->stufe()->split() as $stufe) {
            $usedStufen[$stufe] = true;
        }

        $jahr = $block->jahr()->toDate('Y');

        if ($jahr) {
            $usedJahre[$jahr] = true;
        }
    }

    $usedStufen = array_keys($usedStufen);
    usort($usedStufen, fn ($a, $b) =>
        array_search($a, array_keys($stufenLabelMap)) <=> array_search($b, array_keys($stufenLabelMap))
    );

    $usedJahre = array_keys($usedJahre);
    rsort($usedJahre);
?>

<?php if ($blocks->isNotEmpty()): ?>

    <div class="galerie-filter" id="galerie-filter">
        <div class="galerie-filter-group">
            <button type="button" class="galerie-filter-btn active" data-filter-stufe="all">Alle</button>
            <?php foreach ($usedStufen as $stufe): ?>
                <button type="button" class="galerie-filter-btn" data-filter-stufe="<?= esc($stufe) ?>">
                    <?= esc($stufenLabelMap[$stufe] ?? ucfirst($stufe)) ?>
                </button>
            <?php endforeach ?>
        </div>

        <?php if (count($usedJahre) > 1): ?>
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
        <?php endif ?>
    </div>

    <div class="google-fotos-grid" id="galerie-grid">
        <?php foreach ($blocks as $block): ?>
            <?php
                $foto   = $block->foto()->toFile();
                $name   = $block->name();
                $motto  = $block->motto();
                $link   = $block->link()->toUrl();
                $stufen = $block->stufe()->split();
                $jahr   = $block->jahr()->toDate('Y');

                if (in_array('abteilung', $stufen, true)) {
                    $displayStufen = ['abteilung'];
                } else {
                    $displayStufen = $stufen;
                }
            ?>
            <?php if ($link): ?>
                <a
                    href="<?= esc($link) ?>"
                    class="google-fotos galerie-item"
                    target="_blank"
                    rel="noopener noreferrer"
                    data-stufe="<?= esc(implode(' ', $stufen)) ?>"
                    data-jahr="<?= esc($jahr) ?>"
                >
                    <?php if ($foto): ?>
                        <div class="google-fotos-image">
                            <img src="<?= $foto->resize(600)->url() ?>" alt="<?= esc($name) ?>">
                        </div>
                    <?php endif ?>

                    <div class="google-fotos-content">
                        <div class="google-fotos-name"><?= esc($name) ?></div>

                        <div class="google-fotos-motto"><?= esc($motto) ?></div>

                        <?php if (!empty($stufen)): ?>
                            <div class="google-fotos-stufen aktivitaet-stufen">
                                <?php foreach ($displayStufen as $displayStufe): ?>
                                    <span class="stufe stufe-<?= esc($displayStufe) ?>">
                                        <?= esc($stufenLabelMap[$displayStufe] ?? ucfirst($displayStufe)) ?>
                                    </span>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>

                        <?php if ($jahr): ?>
                            <div class="google-fotos-jahr"><?= esc($jahr) ?></div>
                        <?php endif ?>
                    </div>
                </a>
            <?php endif ?>
        <?php endforeach ?>
    </div>

    <p class="galerie-empty" id="galerie-empty" hidden>Keine Einträge für diese Auswahl gefunden.</p>

<?php endif ?>

<?php snippet('footer') ?>
