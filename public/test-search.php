<?php
// Test script untuk debug live search di hosting
header('Content-Type: application/json');

echo json_encode([
    'status' => 'ok',
    'message' => 'Search endpoint accessible',
    'server_info' => [
        'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'not set',
        'script_filename' => $_SERVER['SCRIPT_FILENAME'] ?? 'not set',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'not set',
        'http_host' => $_SERVER['HTTP_HOST'] ?? 'not set',
    ]
]);
