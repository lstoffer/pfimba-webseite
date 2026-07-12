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

    $stufe = $block->parent()->headerLine()->isNotEmpty()
        ? $block->parent()->headerLine()->value()
        : 'abteilung';
?>

<div class="tabelle tabelle--<?= esc($stufe) ?>">

    <?php if ($titel->isNotEmpty()): ?>
        <h3 class="tabelle-titel"><?= esc($titel) ?></h3>
    <?php endif ?>

    <?php if (!empty($spalten) && $zeilen->isNotEmpty()): ?>
        <table class="tabelle-table">
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
