<?php

use Kirby\Cms\File;
use Kirby\Cms\Page;
use Kirby\Content\Field;
use Kirby\Exception\NotFoundException;
use Kirby\Exception\PermissionException;
use Kirby\Filesystem\Dir;

// Kirby's file permissions are independent of the parent page's own
// "update" permission, so a role with broad file rights can otherwise
// create/replace/delete files even on pages it may only view, not edit.
// This ties file actions to the parent page's "update" permission.
function pfimbaGuardFileParent(File $file): void
{
    $parent = $file->parent();

    if ($parent instanceof Page && $parent->permissions()->can('update') !== true) {
        throw new PermissionException(
            message: 'Du darfst auf dieser Seite keine Dateien verwalten.'
        );
    }
}

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

        // Like toUrl(), but treats a bare domain/path typed into a "url"
        // link field (e.g. "example.com") as external instead of resolving
        // it as a path relative to this site, so editors don't have to
        // type the "https://" scheme themselves.
        'toLinkUrl' => function (Field $field) {
            $value = trim($field->value ?? '');

            if ($value === '') {
                return null;
            }

            $hasScheme = str_contains($value, '://')
                || str_starts_with($value, 'mailto:')
                || str_starts_with($value, 'tel:')
                || str_starts_with($value, '/')
                || str_starts_with($value, '#')
                || str_starts_with($value, './')
                || str_starts_with($value, '../');

            if ($hasScheme === false) {
                $value = 'https://' . $value;
            }

            try {
                return $field->value($value)->toUrl();
            } catch (NotFoundException) {
                return null;
            }
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

    'validators' => [
        // Same as Kirby's built-in "url" validator, but the scheme/"//"
        // prefix is optional, so editors can type "example.com" in a url
        // field without the Panel rejecting it for missing "https://".
        // toLinkUrl() adds the "https://" back when the value is rendered.
        'url' => function ($value): bool {
            $regex = '%^(?:(?:(?:https?|ftp):)?\/\/)?(?:\S+(?::\S*)?@)?(?:(?!(?:10)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:localhost)|(?:[a-z0-9\x{00a1}-\x{ffff}](?:[a-z0-9\x{00a1}-\x{ffff}_-]{0,62}[a-z0-9\x{00a1}-\x{ffff}])?\.)+(?:[a-z\x{00a1}-\x{ffff}]{2,}))(?::\d{2,5})?(?:[/?#]\S*)?$%iuS';
            return preg_match($regex, $value ?? '') !== 0;
        },
    ],

    'hooks' => [
        'file.create:before' => fn (File $file) => pfimbaGuardFileParent($file),
        'file.delete:before' => fn (File $file) => pfimbaGuardFileParent($file),
        'file.replace:before' => fn (File $file) => pfimbaGuardFileParent($file),
        'file.update:before' => fn (File $file) => pfimbaGuardFileParent($file),
        'file.changeName:before' => fn (File $file) => pfimbaGuardFileParent($file),
        'file.changeSort:before' => fn (File $file) => pfimbaGuardFileParent($file),
    ],

]);
