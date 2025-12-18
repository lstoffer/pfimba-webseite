<?php
    $foto   = $block->foto()->toFile();
    $name   = $block->name();
    $link   = $block->link()->toUrl();
    $stufen = $block->stufe()->split();

    if (in_array('abteilung', $stufen, true)) {
    $displayStufen = ['abteilung'];
    } else {
    $displayStufen = $stufen;
    }


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

<?php if ($link): ?>
  <a
    href="<?= esc($link) ?>"
    class="google-fotos"
    target="_blank"
    rel="noopener noreferrer"
  >

    <?php if ($foto): ?>
      <div class="google-fotos-image">
        <img
          src="<?= $foto->resize(600)->url() ?>"
          alt="<?= esc($name) ?>"
        >
      </div>
    <?php endif ?>

    <div class="google-fotos-content">

      <div class="google-fotos-name">
        <?= esc($name) ?>
      </div>

      <?php if (!empty($stufen)): ?>
        <div class="google-fotos-stufen aktivitaet-stufen">
          <?php foreach ($displayStufen as $displayStufe): ?>
            <span class="stufe stufe-<?= esc($displayStufe) ?>">
              <?= esc($stufenLabelMap[$displayStufe] ?? ucfirst($displayStufe)) ?>
            </span>
          <?php endforeach ?>
        </div>
      <?php endif ?>

    </div>

  </a>
<?php endif ?>