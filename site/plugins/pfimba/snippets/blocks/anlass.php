<?php
  $name           = $block->name();
  $verantwortung  = $block->verantwortung();
  $datum          = $block->datum();
  $mehrtaegig     = $block->mehrtaegig()->toBool();
  $enddatum       = $block->enddatum();
  $link           = $block->link()->toUrl();
  $stufen         = $block->stufe()->split();

  $stufenLabelMap = [
      'abteilung' => 'Abteilung',
      'biber'     => 'Biber',
      'woelfe'    => 'Wölfe',
      'pfadis'    => 'Pfadis',
      'pios'      => 'Pios',
      'rover'     => 'Rover',
      'elternrat' => 'Elternrat',
  ];
?>

<div class="anlass">

  <?php if ($name->isNotEmpty()): ?>
    <h4 class="anlass-name">
      <?= esc($name) ?>
    </h4>
  <?php endif ?>

  <?php if ($datum->isNotEmpty()): ?>
    <div class="anlass-datum">
      <?php if ($mehrtaegig && $enddatum->isNotEmpty()): ?>
        <?= $datum->toWeekdayDate('d.m.Y') ?> – <?= $enddatum->toWeekdayDate('d.m.Y') ?>
      <?php else: ?>
        <?= $datum->toWeekdayDate('d.m.Y') ?>
      <?php endif ?>
    </div>
  <?php endif ?>

  <?php if (!empty($stufen)): ?>
    <div class="anlass-stufen aktivitaet-stufen">
      <?php foreach ($stufen as $stufe): ?>
        <span class="stufe stufe-<?= esc($stufe) ?>">
          <?= esc($stufenLabelMap[$stufe] ?? ucfirst($stufe)) ?>
        </span>
      <?php endforeach ?>
    </div>
  <?php endif ?>

  <?php if ($verantwortung->isNotEmpty()): ?>
    <div class="anlass-verantwortung">
      <span class="label">Verantwortung:</span>
      <span class="value"><?= esc($verantwortung) ?></span>
    </div>
  <?php endif ?>

  <?php if ($link): ?>
    <a href="<?= esc($link) ?>" class="anlass-button" target="_blank" rel="noopener noreferrer">
      Weitere Infos
    </a>
  <?php endif ?>

</div>
