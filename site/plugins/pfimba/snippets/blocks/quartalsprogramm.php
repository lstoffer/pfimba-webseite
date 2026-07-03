<?php
    $titel     = $block->titel();
    $eintraege = $block->eintraege()->toStructure()
        ->sortBy(fn ($row) => $row->datum()->toDate(), 'asc');

    $stufe = $block->parent()->headerLine()->isNotEmpty()
        ? $block->parent()->headerLine()->value()
        : 'abteilung';
?>

<div class="quartalsprogramm quartalsprogramm--<?= esc($stufe) ?>">

    <?php if ($titel->isNotEmpty()): ?>
        <h3 class="quartalsprogramm-titel"><?= esc($titel) ?></h3>
    <?php endif ?>

    <?php if ($eintraege->isNotEmpty()): ?>
        <table class="quartalsprogramm-table">
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Aktivität</th>
                    <th>Leiter</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eintraege as $eintrag): ?>
                    <tr>
                        <td data-label="Datum"><?= $eintrag->datum()->toDate('d.m.Y') ?></td>
                        <td data-label="Aktivität"><?= esc($eintrag->aktivitaet()) ?></td>
                        <td data-label="Leiter"><?= esc($eintrag->leiter()) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>

</div>
