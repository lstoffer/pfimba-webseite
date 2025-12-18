<?php
  $name           = $block->name();
  $verantwortung  = $block->verantwortung();
  $datum          = $block->datum();
?>

<div class="anlass">

  <?php if ($name->isNotEmpty()): ?>
    <h4 class="anlass-name">
      <?= esc($name) ?>
    </h4>
  <?php endif ?>

  <?php if ($datum->isNotEmpty()): ?>
    <div class="anlass-datum">
      <?= $datum->toDate('d.m.Y') ?>
    </div>
  <?php endif ?>

  <?php if ($verantwortung->isNotEmpty()): ?>
    <div class="anlass-verantwortung">
      <span class="label">Verantwortung:</span>
      <span class="value"><?= esc($verantwortung) ?></span>
    </div>
  <?php endif ?>

</div>