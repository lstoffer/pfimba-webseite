<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="<?= $site->description()?>">
    <title>
        <?php $page->title() ?> | <?php $site->title() ?>
    </title>
</head>

<body>
    <header>
        <div class="header-logo"></div>
        <nav>
            <ul>
                <?php foreach ($site->children()->listed() as $item): ?>
                <li>
                    <a href="<?= $item->url() ?>"><?= $item->title()?></a>
                    <ul>
                        <?php foreach ($item->children()->listed() as $child): ?>
                        <li>
                            <a href="<?= $child->url() ?>"><?= $child->title()?></a>
                        </li>
                    </ul>
                    <?php endforeach ?>
                </li>
                <?php endforeach ?>
            </ul>
        </nav>
    </header>