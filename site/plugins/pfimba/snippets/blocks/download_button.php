<?php
    $titel = $block->titel();
    $datei = $block->datei()->toFile();
?>

<?php if ($datei): ?>
    <a href="<?= $datei->url() ?>" class="download-button" download>
        <i class="fas fa-download"></i>
        <span><?= esc($titel) ?></span>
    </a>
<?php endif ?>
