<?php snippet('header') ?>

<h1><?= $page->title() ?></h1>

<?= $page->inhaltselemente()->toBlocks() ?>


<?php snippet('footer') ?>