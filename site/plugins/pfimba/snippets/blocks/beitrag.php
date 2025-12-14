<?php
  $titel        = $block->titel();
  $text         = $block->text();
  $bild         = $block->bild()->toFile();
  $bildPosition = $block->bild_position()->value() ?? 'top';
?>

<article class="beitrag beitrag-<?= esc($bildPosition) ?>">

  <h3 class="beitrag-titel">
    <?= esc($titel) ?>
  </h3>

  <?php if ($bild && $bildPosition === 'top'): ?>
    <div class="beitrag-bild">
      <img
        src="<?= $bild->resize(1200)->url() ?>"
        alt="<?= esc($titel) ?>"
      >
    </div>
  <?php endif ?>

  <div class="beitrag-content">

    <?php if ($bild && $bildPosition): ?>
      <div class="beitrag-bild">
        <img
          src="<?= $bild->resize(800)->url() ?>"
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