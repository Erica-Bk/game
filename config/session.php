<?php
/**
 * Central session bootstrap.
 * Included by every entry point instead of calling session_start()
 * directly, so session settings stay consistent everywhere.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,   // JS can't read the cookie
        'samesite' => 'Lax',
    ]);
    session_start();
}
