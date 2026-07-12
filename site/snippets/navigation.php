<nav class="navigation" id="site-navigation">
<ul>
<?php foreach($site->children()->listed() as $item): ?>
    <?php $hasChildren = $item->children()->listed()->count() > 0 ?>
    <li class="<?= $item->isOpen() ? 'active' : '' ?><?= $hasChildren ? ' has-children' : '' ?>">
        <a href="<?= $item->url() ?>"><?= $item->title() ?></a>

        <?php if($hasChildren): ?>
        <button class="submenu-toggle" type="button" aria-label="Untermenü öffnen" aria-expanded="false">
            <span></span>
        </button>
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
