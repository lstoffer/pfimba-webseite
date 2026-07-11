<?php
    $titel = $block->titel();
    $jahr  = $block->jahr()->toDate('Y');
    $datei = $block->datei()->toFile();
?>

<?php if ($datei): ?>
    <a
        href="<?= $datei->url() ?>"
        class="archiv-dokument galerie-item"
        target="_blank"
        rel="noopener noreferrer"
        data-jahr="<?= esc($jahr) ?>"
    >
        <div class="archiv-dokument-image">
            <?php if ($preview = $datei->pdfPreviewUrl()): ?>
                <img src="<?= $preview ?>" alt="<?= esc($titel) ?>">
            <?php else: ?>
                <div class="archiv-dokument-fallback">
                    <i class="fas fa-file-pdf"></i>
                </div>
            <?php endif ?>
        </div>

        <div class="archiv-dokument-content">
            <div class="archiv-dokument-titel"><?= esc($titel) ?></div>
        </div>
    </a>
<?php endif ?>
