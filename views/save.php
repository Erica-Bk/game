<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json');

if (empty($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Not logged in']);
    exit;
}

$raw = file_get_contents('php://input');
$decoded = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid data']);
    exit;
}

$_SESSION['avatar'] = $decoded;

echo json_encode(['ok' => true]);