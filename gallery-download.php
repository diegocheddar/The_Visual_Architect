<?php
// Strasser client gallery download endpoint.
// Add/remove filenames here when the Strasser gallery images change.
$allowed = [
    'Alki_01.jpg',
    'Alki_02.jpg',
    'Alki_03.jpg',
    'Alki_04.jpg',
    'Alki_05.jpg',
    'Alki_301.zip',
];

$assetDir = __DIR__ . '/assets/client-galleries/strasser/';

if (isset($_GET['all'])) {
    if (!class_exists('ZipArchive')) {
        http_response_code(500);
        exit('ZIP downloads are not available on this server.');
    }

    $tmp = tempnam(sys_get_temp_dir(), 'strasser-gallery-');
    $zip = new ZipArchive();
    if ($zip->open($tmp, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        http_response_code(500);
        exit('Unable to create download.');
    }

    foreach ($allowed as $name) {
        $path = $assetDir . $name;
        if (is_file($path)) {
            $zip->addFile($path, $name);
        }
    }
    $zip->close();

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="strasser-image-gallery.zip"');
    header('Content-Length: ' . filesize($tmp));
    header('Cache-Control: private, no-store');
    readfile($tmp);
    @unlink($tmp);
    exit;
}

$file = isset($_GET['file']) ? basename($_GET['file']) : '';
if (!in_array($file, $allowed, true)) {
    http_response_code(404);
    exit('Image not found.');
}

$path = $assetDir . $file;
if (!is_file($path)) {
    http_response_code(404);
    exit('Image not found.');
}

$mime = function_exists('mime_content_type') ? mime_content_type($path) : 'application/octet-stream';
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Length: ' . filesize($path));
header('Cache-Control: private, no-store');
readfile($path);
exit;
