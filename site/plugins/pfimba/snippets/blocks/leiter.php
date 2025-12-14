<?php
  $foto      = $block->foto()->toFile();
  $vorname   = $block->vorname();
  $nachname  = $block->nachname();
  $pfadiname = $block->pfadiname();
  $email     = $block->email();
  $telefon   = $block->telefon();
  $funktion  = $block->funktion();


  $name = $vorname . ' ' . $nachname;
  if($pfadiname->isNotEmpty()) {
    $name .= ' v/o ' . $pfadiname;
  }

?>

<div class="leiter">

  <?php if ($foto): ?>
    <div class="leiter-foto">
      <img
        src="<?= $foto->resize(400)->url() ?>"
        alt="<?= esc($name) ?>"
      >
    </div>
  <?php endif ?>

  <div class="leiter-content">

    <h4 class="leiter-name">
      <?= esc($name) ?>
    </h4>

    <?php if ($funktion->isNotEmpty()): ?>
      <div class="leiter-funktion">
        <?= ucfirst(esc($funktion)) ?>
      </div>
    <?php endif ?>

    <div class="leiter-kontakt">
      <a class="email" href="mailto:<?= esc($email) ?>">
        <?= esc($email) ?>
      </a>

      <?php if ($telefon->isNotEmpty()): ?>
        <span class="telefon">
          <?= esc($telefon) ?>
        </span>
      <?php endif ?>
    </div>

  </div>

</div>