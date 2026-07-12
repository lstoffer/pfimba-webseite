<?php
    $bild        = $block->bild()->toFile();
    $link        = $block->link()->toUrl();
    $groesse     = $block->groesse()->value() ?: 'voll';
    $ausrichtung = $block->ausrichtung()->value() ?: 'mitte';

    $classes = 'bild-block bild-block--groesse-' . esc($groesse) . ' bild-block--ausrichtung-' . esc($ausrichtung);
?>

<?php if ($bild): ?>
    <?php if ($link): ?>
        <a href="<?= esc($link) ?>" class="<?= $classes ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?= $bild->resize(1600)->url() ?>" alt="">
        </a>
    <?php else: ?>
        <div class="<?= $classes ?>">
            <img src="<?= $bild->resize(1600)->url() ?>" alt="">
        </div>
    <?php endif ?>
<?php endif ?>
