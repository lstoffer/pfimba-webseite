<?php

$headerImage = $page->headerImage()->toFile();

?>

<head>
    <?= css([ // IMPORTANT: Oder matters
        '/assets/css/fonts.css',
        '/assets/fontawesome/css/all.min.css',
        '/assets/css/variables.css',
        '/assets/css/header_styles.css',
        '/assets/css/footer_styeles.css',
        '/assets/css/styles.css'
    ])?>
    <link rel="icon" href="<?= url('/assets/images/faveicon_rgb.png') ?>">
</head>

<header 
    id="header" 
    class="border <?= $page->headerLine()->value() ?>" 
    <?php if($headerImage): ?>style="background-image:url('<?= $headerImage->url() ?>');"<?php endif; ?>
>

    <div class="header-logo">
        <a href="/">
            <img id='header-image' src="<?= url('/assets/images/logo/logo_rgb.png') ?>" alt="logo">
        </a>
    </div>

    <?php snippet('navigation') ?>

</header>

<body id="page">
    
