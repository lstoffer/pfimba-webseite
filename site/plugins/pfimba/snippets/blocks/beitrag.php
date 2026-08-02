<?php
  $titel        = $block->titel();
  $text         = $block->text();
  $bild         = $block->bild()->toFile();
  $bildPosition = $block->bild_position()->value() ?? 'top-center';
  $bildGroesse  = $block->bild_groesse()->value() ?? 'normal';
  $textAlign    = $block->text_ausrichtung()->value() ?? 'links';

  $link           = $block->link()->toLinkUrl();
  $linkIsExternal = $link && str_starts_with($link, 'http') && !str_starts_with($link, site()->url());
  $tag            = $link ? 'a' : 'article';
?>

<<?= $tag ?>
  class="beitrag beitrag--<?= esc($bildPosition) ?> beitrag--img-<?= esc($bildGroesse) ?> beitrag--text-<?= esc($textAlign) ?>"
  <?php if ($link): ?>href="<?= esc($link) ?>"<?php if ($linkIsExternal): ?> target="_blank" rel="noopener"<?php endif; ?><?php endif; ?>
>

  <?php if ($titel->isNotEmpty()): ?>
    <h3 class="beitrag-titel">
      <?= esc($titel) ?>
    </h3>
  <?php endif ?>

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

</<?= $tag ?>>
