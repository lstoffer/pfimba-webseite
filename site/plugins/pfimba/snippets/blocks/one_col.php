<section class="content one">

    <?php foreach ($block->spalteninhalt()->toBlocks() as $inner): ?>
        <?= $inner ?>
    <?php endforeach ?>

</section>