<?php

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
