<?php
// Vercel env check - bare PHP, no Laravel
$info = [
    'php_version' => phpversion(),
    'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
    'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'unknown',
    'cwd' => getcwd(),
    'functions' => get_loaded_extensions(),
    'pdo_drivers' => class_exists('PDO') ? PDO::getAvailableDrivers() : [],
    'upload_max' => ini_get('upload_max_filesize'),
    'memory_limit' => ini_get('memory_limit'),
    'storage_writable' => is_writable('/tmp'),
    'env_app_key' => getenv('APP_KEY') ? substr(getenv('APP_KEY'), 0, 20).'...' : 'NOT SET',
    'env_db_host' => getenv('DB_HOST') ?: 'NOT SET',
];
header('Content-Type: application/json');
echo json_encode($info, JSON_PRETTY_PRINT);
