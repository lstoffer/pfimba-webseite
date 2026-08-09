<?php

    $leitpersonName = $block->leitperson();
    $leitpersonEmail = $block->email_leitperson();
    $leitpersonTelefon = $block->telefon_leitperson();

    $besammlungsort = $block->besammlungsort()->toLinkUrl();
    $besammlungsortIstExternal = $besammlungsort && str_starts_with($besammlungsort, 'http') && !str_starts_with($besammlungsort, site()->url());

    $schlussort = $block->schlussort()->toLinkUrl();
    $schlussortIstExternal = $schlussort && str_starts_with($schlussort, 'http') && !str_starts_with($schlussort, site()->url());

    $leitpersonKontakt = [];

    if($leitpersonEmail->isNotEmpty()) {
        $leitpersonKontakt[] = '<a href="mailto:' . $leitpersonEmail . '">' . $leitpersonEmail . '</a>';
    }

    if($leitpersonTelefon->isNotEmpty()) {
        $leitpersonKontakt[] = $leitpersonTelefon;
    }

    if(!empty($leitpersonKontakt)) {
        $leitpersonInfo = $leitpersonName . ' (' . implode(' / ', $leitpersonKontakt) . ')';
    }



    $stufenGrussMap = [
        'biber'   => 'Mit Freud debi',
        'woelfe'  => 'Üses Bescht',
        'pfadis'  => 'Allzeit bereit',
        'pios'    => 'Zemme witer',
    ];

    $stufenLabelMap = [
        'abteilung' => 'Abteilung',
        'biber'     => 'Biber',
        'woelfe'    => 'Wölfe',
        'pfadis'    => 'Pfadis',
        'pios'      => 'Pios',
    ];

    $selectedStufen = $block->stufen()->split();

    $primaryStufe = in_array('abteilung', $selectedStufen, true)
        ? 'abteilung'
        : ($selectedStufen[0] ?? 'abteilung');

    if (in_array('abteilung', $selectedStufen, true)) {
        $gruesse = array_values($stufenGrussMap);
    } else {
        $gruesse = [];

        foreach ($selectedStufen as $stufe) {
            if (isset($stufenGrussMap[$stufe])) {
                $gruesse[] = $stufenGrussMap[$stufe];
            }
        }
    }

    if (count($gruesse) > 1) {
        $last  = array_pop($gruesse);
        $gruss = implode(', ', $gruesse) . ' & ' . $last;
    } else {
        $gruss = $gruesse[0] ?? '';
    }

?>



<div class="aktivitaet aktivitaet--stufe-<?= esc($primaryStufe) ?>">

    <div class="aktivitaet-meta">
        <h3> <?= $block->titel() ?> </h3>
        
        <div class="datum"> <?= $block->datum()->toDate('d.m.Y') ?> </div>
    
        <div class="aktivitaet-stufen">
            <?php foreach ($block->stufen()->split() as $stufe): ?>
                <span class="stufe stufe-<?= esc($stufe) ?>">
                    <?= esc($stufenLabelMap[$stufe] ?? ucfirst($stufe)) ?>
                </span>
            <?php endforeach ?>
        </div>

    </div>


    <?php if ($block->info()->isNotEmpty()): ?>
        <p>
            <?= $block->info() ?>
        </p>
    <?php endif ?>

    <div class="aktivitaet-details">
        <span class="label">Besammlung:</span>
        <span class="value">
            <?= $block->besammlung() ?>
            <?php if ($besammlungsort): ?>
                <a
                    href="<?= esc($besammlungsort) ?>"
                    class="ort-link"
                    <?php if ($besammlungsortIstExternal): ?>target="_blank" rel="noopener"<?php endif; ?>
                    aria-label="Besammlungsort auf Karte anzeigen"
                ><i class="fas fa-map-marker-alt"></i></a>
            <?php endif; ?>
        </span>

        <span class="label">Schluss:</span>
        <span class="value">
            <?= $block->schluss() ?>
            <?php if ($schlussort): ?>
                <a
                    href="<?= esc($schlussort) ?>"
                    class="ort-link"
                    <?php if ($schlussortIstExternal): ?>target="_blank" rel="noopener"<?php endif; ?>
                    aria-label="Schlussort auf Karte anzeigen"
                ><i class="fas fa-map-marker-alt"></i></a>
            <?php endif; ?>
        </span>

        <span class="label label-spaced">Mitnehmen:</span>
        <span class="value value-spaced"><?= $block->mitnehmen() ?></span>
    </div>

    <p>
        Bei Fragen und Abmeldungen <br>
        <?= $leitpersonInfo ?>
    </p>

    <p>
        <?= $gruss ?> <br>
        Euer Leitungsteam
    </p>

</div>

