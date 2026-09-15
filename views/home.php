<?php
require_once __DIR__ . '/../config/session.php';
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$avatarData = $_SESSION['avatar'] ?? [];

$layerOrder = ['back', 'body', 'pant', 'shoe', 'dress', 'shirt', 'front', 'eye', 'mouth', 'eyebrow', 'accessory'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Ant</title>
    <style>
        * {
            font-family: 'UD Digi Kyokasho N-B', 'Segoe UI', system-ui, -apple-system, sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 24px;
            background: #f7f5fb;
        }

        h1 {
            margin: 0;
            color: #333;
        }

        .empty-state {
            color: #888;
            font-size: 0.95rem;
        }

        .body-container {
            width: 400px;
            height: 700px;
            border-radius: 25px;
            overflow: hidden;
            position: relative;
            background: #fff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .body-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        a.back-link {
            color: #AC91EB;
            text-decoration: none;
            font-size: 0.9rem;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Your Saved Ant 🐜</h1>

    <?php if (empty($avatarData)): ?>
        <p class="empty-state">No avatar data found yet — go back and hit SAVE.</p>
    <?php else: ?>
        <div class="body-container">
            <?php foreach ($layerOrder as $layer): ?>
                <?php if (!empty($avatarData[$layer]['visible']) && !empty($avatarData[$layer]['src'])): ?>
                    <img src="<?php echo htmlspecialchars($avatarData[$layer]['src']) ?>" alt="<?php echo htmlspecialchars($layer) ?>">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="dashboard.php" class="back-link">← Back to editor</a>
</body>
</html>