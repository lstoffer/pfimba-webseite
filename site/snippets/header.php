<?php

$headerImage = $page->headerImage()->toFile();

?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= css([ // IMPORTANT: Oder matters
        '/assets/css/fonts.css',
        '/assets/fontawesome/css/all.min.css',
        '/assets/css/variables.css',
        '/assets/css/header_styles.css',
        '/assets/css/footer_styeles.css',
        '/assets/css/styles.css',
        '/assets/css/galerie_styles.css',
        '/assets/css/archiv_styles.css',
    ])?>
    <?= css([
        'media/plugins/pmr/pfimba/css/aktivitaet.css',
        'media/plugins/pmr/pfimba/css/leiter.css',
        'media/plugins/pmr/pfimba/css/anlass.css',
        'media/plugins/pmr/pfimba/css/google_fotos.css',
        'media/plugins/pmr/pfimba/css/beitrag.css',
        'media/plugins/pmr/pfimba/css/quartalsprogramm.css',
        'media/plugins/pmr/pfimba/css/tabelle.css',
        'media/plugins/pmr/pfimba/css/download_button.css',
        'media/plugins/pmr/pfimba/css/akkordeon.css'
    ])?>
    <?= js('/assets/js/navigation.js') ?>
    <?= js('/assets/js/galerie-filter.js') ?>
    <link rel="icon" href="<?= url('/assets/images/faveicon_rgb.png') ?>">
</head>

<header
    id="header"
    class="border <?= $page->headerLine()->value() ?><?= $page->isHomePage() ? ' header--home' : '' ?>"
    <?php if($headerImage): ?>style="background-image:url('<?= $headerImage->url() ?>');"<?php endif; ?>
>

    <div class="header-logo">
        <a href="/">
            <img id='header-image' src="<?= url('/assets/images/logo/logo_rgb.png') ?>" alt="logo">
        </a>
    </div>

    <button
        id="nav-toggle"
        class="nav-toggle"
        type="button"
        aria-label="Menü öffnen"
        aria-expanded="false"
        aria-controls="site-navigation"
    >
        <span></span>
        <span></span>
        <span></span>
    </button>

    <?php snippet('navigation') ?>

</header>

<div id="page">
