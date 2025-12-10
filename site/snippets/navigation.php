<nav class="navigation">
<ul>
<?php foreach($site->children()->listed() as $item): ?>
    <li class="<?= $item->isOpen() ? 'active' : '' ?>">
        <a href="<?= $item->url() ?>"><?= $item->title() ?></a>

        <?php if($item->children()->listed()->count()): ?>
        <ul class="sub-menu">
            <?php foreach($item->children()->listed() as $sub): ?>
                <li><a href="<?= $sub->url() ?>"><?= $sub->title() ?></a></li>
            <?php endforeach ?>
        </ul>
        <?php endif ?>
    </li>
<?php endforeach ?>

</ul>
</nav>