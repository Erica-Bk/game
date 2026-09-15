<?php
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: views/signin.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';
$email    = trim($_POST['email'] ?? '');

if ($password !== $confirm) {
    header('Location: views/signin.php?error=' . urlencode('Passwords do not match.'));
    exit;
}

$auth = new AuthController();
$result = $auth->register($username, $password, $email);

if ($result['success']) {
    header('Location: views/login.php?success=' . urlencode($result['message']));
} else {
    header('Location: views/signin.php?error=' . urlencode($result['message']));
}
exit;
