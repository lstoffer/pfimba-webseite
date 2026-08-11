<?php
    $titel = $block->titel();

    $spalten = [];

    for ($i = 1; $i <= 6; $i++) {
        $label = $block->{'spalte' . $i}();

        if ($label->isNotEmpty()) {
            $spalten[$i] = (string)$label;
        }
    }

    $zeilen = $block->zeilen()->toStructure();
    $filterbar = $block->filterbar()->toBool();
    $filterId = 'tabelle-filter-' . $block->id();

    $stufe = $block->parent()->headerLine()->isNotEmpty()
        ? $block->parent()->headerLine()->value()
        : 'abteilung';
?>

<div class="tabelle tabelle--<?= esc($stufe) ?>">

    <?php if ($titel->isNotEmpty()): ?>
        <h3 class="tabelle-titel"><?= esc($titel) ?></h3>
    <?php endif ?>

    <?php if (!empty($spalten) && $zeilen->isNotEmpty()): ?>

        <?php if ($filterbar): ?>
            <div class="tabelle-filter">
                <input
                    type="search"
                    class="tabelle-filter-input"
                    data-tabelle-filter="<?= esc($filterId) ?>"
                    placeholder="Suchen …"
                    aria-label="Tabelle durchsuchen"
                >
                <button
                    type="button"
                    class="tabelle-filter-clear"
                    aria-label="Suche zurücksetzen"
                    hidden
                >&times;</button>
            </div>
        <?php endif ?>

        <table class="tabelle-table" id="<?= esc($filterId) ?>">
            <thead>
                <tr>
                    <?php foreach ($spalten as $label): ?>
                        <th><?= esc($label) ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($zeilen as $zeile): ?>
                    <tr>
                        <?php foreach ($spalten as $i => $label): ?>
                            <td data-label="<?= esc($label) ?>"><?= $zeile->{'zelle' . $i}() ?></td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>

</div>
