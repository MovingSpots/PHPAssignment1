<?php
declare(strict_types=1);

const UPLOAD_DIRECTORY = __DIR__ . '/uploads/';
const MAX_IMAGE_BYTES = 2 * 1024 * 1024;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function escapeHtml(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function fetchCategories(PDO $db): array
{
    return $db->query('SELECT category_id, category_name FROM categories ORDER BY category_name')->fetchAll();
}

function validateProgram(array $data, array $categories): array
{
    $errors = [];
    $validCategoryIds = array_map(
        static fn(array $category): int => (int) $category['category_id'],
        $categories
    );
    if (trim((string) ($data['program_name'] ?? '')) === '') {
        $errors[] = 'Program name is required.';
    }
    if (!in_array((int) ($data['category_id'] ?? 0), $validCategoryIds, true)) {
        $errors[] = 'Please select a valid category.';
    }
    if (trim((string) ($data['location'] ?? '')) === '') {
        $errors[] = 'Location is required.';
    }
    if (trim((string) ($data['schedule'] ?? '')) === '') {
        $errors[] = 'Schedule is required.';
    }
    if (!filter_var((string) ($data['contact_email'] ?? ''), FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid contact email address.';
    }
    if (trim((string) ($data['description'] ?? '')) === '') {
        $errors[] = 'Description is required.';
    }
    return $errors;
}

function saveUploadedImage(array $file): ?string
{
    $error = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($error === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($error !== UPLOAD_ERR_OK) {
        throw new RuntimeException('The image could not be uploaded. Please try again.');
    }
    if ((int) ($file['size'] ?? 0) > MAX_IMAGE_BYTES) {
        throw new RuntimeException('The image must be 2 MB or smaller.');
    }

    $temporaryPath = (string) ($file['tmp_name'] ?? '');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($temporaryPath);
    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];
    if ($mime === false || !isset($allowedTypes[$mime])) {
        throw new RuntimeException('Choose a JPG, PNG, GIF, or WebP image.');
    }
    if (!is_dir(UPLOAD_DIRECTORY) && !mkdir(UPLOAD_DIRECTORY, 0755, true)) {
        throw new RuntimeException('The upload folder could not be created.');
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$mime];
    if (!move_uploaded_file($temporaryPath, UPLOAD_DIRECTORY . $filename)) {
        throw new RuntimeException('The image could not be saved.');
    }
    return $filename;
}

function deleteUploadedImage(?string $filename): void
{
    if ($filename === null || $filename === '') {
        return;
    }
    $path = UPLOAD_DIRECTORY . basename($filename);
    if (is_file($path)) {
        unlink($path);
    }
}

function redirectWithMessage(string $message): never
{
    header('Location: index.php?message=' . rawurlencode($message));
    exit;
}
