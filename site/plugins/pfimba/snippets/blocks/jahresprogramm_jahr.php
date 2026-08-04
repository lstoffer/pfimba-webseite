<?php
    $jahr = $block->jahr();
?>

<div class="jahresprogramm-jahr">
    <h2 class="jahresprogramm-jahr-titel"><?= esc($jahr) ?></h2>
    <div class="content one">
        <?= $block->anlaesse()->toBlocks() ?>
    </div>
</div>
