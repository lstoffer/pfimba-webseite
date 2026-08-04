<?php snippet('header') ?>

<h1><?= $page->title() ?></h1>

<?= $page->aktivitaeten()->toBlocks() ?>

<?php snippet('footer') ?>
