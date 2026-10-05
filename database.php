<?php
declare(strict_types=1);

// These defaults match a common *local* XAMPP setup. If you set a MySQL
// password, edit it here on your computer; do not commit a real password.
$host = '127.0.0.1';
$database = 'community_programs';
$username = 'root';
$password = '';

try {
    $db = new PDO(
        "mysql:host={$host};dbname={$database};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $exception) {
    error_log('Community Program Directory database connection: ' . $exception->getMessage());
    http_response_code(500);
    require __DIR__ . '/database_error.php';
    exit;
}
