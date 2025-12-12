<?php

    $leiterName = $block->leitperson();
    $leiterEmail = $block->email_leitperson();
    $leiterTelefon = $block->telefon_leitperson();

    $leitperson = [];

    if($leiterEmail->isNotEmpty()) {
        $leitperson[] = '<a href="mailto:' . $leiterEmail . '">' . $leiterEmail . '</a>';
    }

    if($leiterTelefon->isNotEmpty()) {
        $leitperson[] = $leiterTelefon;
    }

    if(!empty($leitperson)) {
        $leitpersonInfo = $leiterName . ' (' . implode(' / ', $leitperson) . ')';
    }



    $stufenGrussMap = [
        'biber'   => 'Mit Freud debi',
        'woelfe'  => 'Üses Bescht',
        'pfadis'  => 'Allzeit bereit',
        'pios'    => 'Zemme witer',
    ];

    $selectedStufen = $block->stufen()->split();

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



<div class="aktivitaet">

    <h3> <?= $block->titel() ?> </h3>
    
    <div class="datum"> <?= $block->datum() ?> </div>

    <div class="aktivitaet-stufen">
        <?php foreach ($block->stufen()->split() as $stufe): ?>
            <span class="stufe stufe-<?= esc($stufe) ?>">
                <?= esc(ucfirst($stufe)) ?>
            </span>
        <?php endforeach ?>
    </div>

    <p>
        <?= $block->info() ?>
    </p>

    <p>
        <b>Besammlung: </b> <?= $block->besammlung() ?> <br>
        <b>Schluss:</b> <?= $block->schluss() ?> <br>
        <b>Mitnehmen:</b> <?= $block->mitnehmen() ?>
    </p>

    <p>
        Bei Fragen und Abmeldungen <br>
        <?= $leitpersonInfo ?>
    </p>

    <p>
        <?= $gruss ?> <br>
        Euer Leitungsteam
    </p>

</div>

