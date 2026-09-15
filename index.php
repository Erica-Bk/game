<?php
require_once __DIR__ . '/config/session.php';

// Already logged in? skip straight to home.
if (!empty($_SESSION['user'])) {
    header('Location: views/home.php');
    exit;
}

header('Location: views/login.php');
exit;
