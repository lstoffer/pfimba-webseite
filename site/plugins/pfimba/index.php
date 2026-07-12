<?php

use Kirby\Content\Field;
use Kirby\Filesystem\Dir;

Kirby::plugin('pmr/pfimba', [
    'blueprints' => [
        'blocks/one_col' => __DIR__ . '/blueprints/blocks/one_col.yml',
        'blocks/two_col' => __DIR__ . '/blueprints/blocks/two_col.yml',
        'blocks/three_col' => __DIR__ . '/blueprints/blocks/three_col.yml',
        'blocks/leiter' => __DIR__ . '/blueprints/blocks/leiter.yml',
        'blocks/aktivitaet' => __DIR__ . '/blueprints/blocks/aktivitaet.yml',
        'blocks/anlass' => __DIR__ . '/blueprints/blocks/anlass.yml',
        'blocks/google_fotos' => __DIR__ . '/blueprints/blocks/google_fotos.yml',
        'blocks/beitrag' => __DIR__ . '/blueprints/blocks/beitrag.yml',
        'blocks/quartalsprogramm' => __DIR__ . '/blueprints/blocks/quartalsprogramm.yml',
        'blocks/archiv_dokument' => __DIR__ . '/blueprints/blocks/archiv_dokument.yml',
        'blocks/tabelle' => __DIR__ . '/blueprints/blocks/tabelle.yml',
        'blocks/download_button' => __DIR__ . '/blueprints/blocks/download_button.yml',
        'blocks/akkordeon' => __DIR__ . '/blueprints/blocks/akkordeon.yml',
        'blocks/bild' => __DIR__ . '/blueprints/blocks/bild.yml',
    ],

    'snippets' => [
        'blocks/one_col'     => __DIR__ . '/snippets/blocks/one_col.php',
        'blocks/two_col'     => __DIR__ . '/snippets/blocks/two_col.php',
        'blocks/three_col'     => __DIR__ . '/snippets/blocks/three_col.php',
        'blocks/aktivitaet'  => __DIR__ . '/snippets/blocks/aktivitaet.php',
        'blocks/leiter'      => __DIR__ . '/snippets/blocks/leiter.php',
        'blocks/anlass'      => __DIR__ . '/snippets/blocks/anlass.php',
        'blocks/google_fotos'      => __DIR__ . '/snippets/blocks/google_fotos.php',
        'blocks/beitrag' => __DIR__ . '/snippets/blocks/beitrag.php',
        'blocks/quartalsprogramm' => __DIR__ . '/snippets/blocks/quartalsprogramm.php',
        'blocks/archiv_dokument' => __DIR__ . '/snippets/blocks/archiv_dokument.php',
        'blocks/tabelle' => __DIR__ . '/snippets/blocks/tabelle.php',
        'blocks/download_button' => __DIR__ . '/snippets/blocks/download_button.php',
        'blocks/akkordeon' => __DIR__ . '/snippets/blocks/akkordeon.php',
        'blocks/bild' => __DIR__ . '/snippets/blocks/bild.php',
    ],

    'fieldMethods' => [
        // Formats a date field as "WD dd.mm.YYYY" with the German
        // two-letter weekday abbreviation (MO, DI, MI, DO, FR, SA, SO)
        'toWeekdayDate' => function (Field $field, string $format = 'd.m.Y') {
            $timestamp = $field->toDate();

            if ($timestamp === null) {
                return null;
            }

            $wochentage = [
                1 => 'MO',
                2 => 'DI',
                3 => 'MI',
                4 => 'DO',
                5 => 'FR',
                6 => 'SA',
                7 => 'SO',
            ];

            $wochentag = $wochentage[(int)date('N', $timestamp)];

            return $wochentag . ' ' . date($format, $timestamp);
        },
    ],

    'fileMethods' => [
        // Renders the first page of a PDF to a cached JPG preview image.
        // Uses Ghostscript directly, since ImageMagick's default security
        // policy disables its PDF coder.
        'pdfPreviewUrl' => function () {
            if ($this->extension() !== 'pdf') {
                return null;
            }

            $filename = sha1($this->id() . $this->modified()) . '.jpg';
            $dir      = $this->kirby()->root('index') . '/media/pdf-previews';
            $root     = $dir . '/' . $filename;

            if (is_file($root) === false) {
                Dir::make($dir, true);

                $command = 'gs -dNOPAUSE -dBATCH -dSAFER -sDEVICE=jpeg -dFirstPage=1 -dLastPage=1 -r150 '
                    . '-sOutputFile=' . escapeshellarg($root) . ' '
                    . escapeshellarg($this->root()) . ' 2>&1';

                shell_exec($command);

                if (is_file($root) === false) {
                    return null;
                }
            }

            return url('media/pdf-previews/' . $filename);
        },
    ],

]);
