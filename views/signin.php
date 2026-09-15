<?php
require_once __DIR__ . '/../config/session.php';
if (!empty($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$notice = $_GET['notice'] ?? '';
$error  = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐜 ant grid - Sign up</title>
    <style>
        * { font-family: 'UD Digi Kyokasho N-B', 'Segoe UI', system-ui, -apple-system, sans-serif; box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; position: relative; display: flex; align-items: center; justify-content: center; }
        .bg-grid {
            position: absolute; inset: 0;
            background-image: linear-gradient(#cccccc 1px, transparent 1px), linear-gradient(90deg, #cccccc 1px, transparent 1px);
            background-size: 40px 40px; opacity: 0.3; pointer-events: none; z-index: -1;
        }
        .card { position: relative; z-index: 1; background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 32px; width: 320px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
        h1 { margin-top: 0; font-size: 1.3rem; }
        label { display: block; margin: 12px 0 4px; font-size: 0.85rem; color: #444; }
        input { width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 0.95rem; }
        button { margin-top: 18px; width: 100%; padding: 10px; border: none; border-radius: 4px; background: #222; color: #fff; font-size: 0.95rem; cursor: pointer; }
        button:hover { background: #000; }
        .msg { font-size: 0.8rem; padding: 8px; border-radius: 4px; margin-top: 12px; }
        .notice { background: #fff3cd; color: #856404; }
        .error { background: #f8d7da; color: #721c24; }
        .link { display: block; text-align: center; margin-top: 14px; font-size: 0.85rem; }
        a { color: #444; }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="card">
        <h1>🐜 ant grid - Create account</h1>

        <?php if ($notice): ?>
            <div class="msg notice"><?php echo htmlspecialchars($notice); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="msg error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="../register_process.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autofocus>

            <label for="email">Email (optional)</label>
            <input type="email" id="email" name="email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Create account</button>
        </form>

        <span class="link">Already have an account? <a href="login.php">Log in</a></span>
    </div>
</body>
</html>
