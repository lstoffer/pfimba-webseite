<?php
  $titel        = $block->titel();
  $text         = $block->text();
  $bild         = $block->bild()->toFile();
  $bildPosition = $block->bild_position()->value() ?? 'top-center';
  $bildGroesse  = $block->bild_groesse()->value() ?? 'normal';
  $textAlign    = $block->text_ausrichtung()->value() ?? 'links';
?>

<article class="beitrag beitrag--<?= esc($bildPosition) ?> beitrag--img-<?= esc($bildGroesse) ?> beitrag--text-<?= esc($textAlign) ?>">

  <h3 class="beitrag-titel">
    <?= esc($titel) ?>
  </h3>

  <div class="beitrag-content">

    <?php if ($bild): ?>
      <div class="beitrag-bild">
        <img
          src="<?= $bild->resize(1200)->url() ?>"
          alt="<?= esc($titel) ?>"
        >
      </div>
    <?php endif ?>

    <?php if ($text->isNotEmpty()): ?>
      <div class="beitrag-text">
        <?= $text->kirbytext() ?>
      </div>
    <?php endif ?>

  </div>

</article>
