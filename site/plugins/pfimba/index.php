<?php 

Kirby::plugin('pmr/pfimba', [
    'blueprints' => [
        'blocks/one_col' => __DIR__ . '/blueprints/blocks/one_col.yml',
        'blocks/two_col' => __DIR__ . '/blueprints/blocks/two_col.yml',
        'blocks/leiter' => __DIR__ . '/blueprints/blocks/leiter.yml',
        'blocks/aktivitaet' => __DIR__ . '/blueprints/blocks/aktivitaet.yml',
        'blocks/anlass' => __DIR__ . '/blueprints/blocks/anlass.yml',
        'blocks/google_fotos' => __DIR__ . '/blueprints/blocks/google_fotos.yml',
    ],

    'snippets' => [
        'blocks/one_col'     => __DIR__ . '/snippets/blocks/one_col.php',
        'blocks/two_col'     => __DIR__ . '/snippets/blocks/two_col.php',
        'blocks/aktivitaet'  => __DIR__ . '/snippets/blocks/aktivitaet.php',
        'blocks/leiter'      => __DIR__ . '/snippets/blocks/leiter.php',
        'blocks/anlass'      => __DIR__ . '/snippets/blocks/anlass.php',
        'blocks/google_fotos'      => __DIR__ . '/snippets/blocks/google_fotos.php',
    ],

]);

