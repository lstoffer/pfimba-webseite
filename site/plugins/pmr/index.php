<?php 

Kirby::plugin('getkirby/pmr', [
    'blueprints' => [
        'blocks/leiter' => __DIR__ . '/blueprints/blocks/leiter.yml',
        'blocks/aktivitaet' => __DIR__ . '/blueprints/blocks/aktivitaet.yml',
        'blocks/anlass' => __DIR__ . '/blueprints/blocks/anlass.yml',
    ]
]);

?>