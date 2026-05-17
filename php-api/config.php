<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Load environment variables from .env file if it exists
$env_file = dirname(__DIR__) . '/.env';
if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (!empty($key)) {
                $_ENV[$key] = $value;
            }
        }
    }
}

// Database configuration - تقرأ من متغيرات البيئة أو تستخدم القيم الافتراضية
$db_host = $_ENV['DB_HOST'] ?? "localhost";
$db_user = $_ENV['DB_USER'] ?? "alasimh_asd";
$db_pass = $_ENV['DB_PASSWORD'] ?? "asd2026@1A";
$db_name = $_ENV['DB_NAME'] ?? "alasimh_baba";

try {
    $conn = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch(PDOException $exception) {
    // Do not exit — allow API to fall back to file-based storage when DB is unavailable
    $conn = null;
    $db_error = $exception->getMessage();
}
?>
