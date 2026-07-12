<?php
    $titel         = $block->titel();
    $offenStandard = $block->offenStandard()->toBool();
    $inhalt        = $block->inhalt()->toBlocks();
?>

<details class="akkordeon"<?= $offenStandard ? ' open' : '' ?>>
    <summary class="akkordeon-titel">
        <span><?= esc($titel) ?></span>
        <i class="fas fa-chevron-down akkordeon-icon"></i>
    </summary>
    <div class="akkordeon-inhalt">
        <?= $inhalt ?>
    </div>
</details>
