<?php
require_once __DIR__ . '/../config/session.php';
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'game'; ?></title>
    <link rel="icon" type="image/svg+xml" href="../assets/icons/ant.ico">
    <style>
        * {
            font-family: 'UD Digi Kyokasho N-B', 'Segoe UI', system-ui, -apple-system, sans-serif;
            box-sizing: border-box;
            cursor: url('../assets/icons/moon-fish.png') 16 16, auto !important;
        }

        body {
            margin: 0;
            min-height: 100vh;
            position: relative;
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(#AC91EB 2px, transparent 2px),
                linear-gradient(90deg, #AC91EB 2px, transparent 2px);
            background-size: 40px 40px;
            opacity: 0.3;
            pointer-events: none;
            z-index: -1;
        }

        .navbar {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 32px;
            background: #ffffffcc;
            backdrop-filter: blur(6px);
            border-bottom: 1px solid #ddd;
        }

        .navbar-brand {
            font-size: 1.1rem;
            font-weight: bold;
            color: #222;
        }

        .navbar-links {
            display: flex;
            gap: 24px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar-links a {
            text-decoration: none;
            color: #444;
            font-size: 0.9rem;
        }

        .navbar-links a:hover {
            color: #000;
        }

        .user-menu {
            position: relative;
        }

        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 0.85rem;
            color: #333;
            cursor: pointer;
        }

        .user-menu-btn:hover {
            background: #f2f2f2;
        }

        .user-menu-btn .caret {
            font-size: 0.7rem;
            transition: transform 0.15s ease;
        }

        .user-menu.open .caret {
            transform: rotate(180deg);
        }

        .user-menu-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            min-width: 160px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            display: none;
        }

        .user-menu.open .user-menu-dropdown {
            display: block;
        }

        .user-menu-dropdown .menu-header {
            padding: 10px 14px;
            font-size: 0.75rem;
            color: #888;
            border-bottom: 1px solid #eee;
        }

        .user-menu-dropdown a {
            display: block;
            padding: 10px 14px;
            font-size: 0.85rem;
            color: #333;
            text-decoration: none;
        }

        .user-menu-dropdown a:hover {
            background: #f5f5f5;
        }

        .user-menu-dropdown a.logout-link {
            color: #c0392b;
        }

        .content {
            position: relative;
            padding: 40px;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin-top: 20px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 16px;
            max-width: 380px;
            min-height: 700px;
        }

        .menu-tabs {
            display: flex;
            flex-wrap: nowrap;
            gap: 16px 20px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 8px;
            scrollbar-width: thin;
        }

        .menu-tabs::-webkit-scrollbar {
            height: 6px;
        }

        .menu-tabs::-webkit-scrollbar-thumb {
            background: #AC91EB;
            border-radius: 4px;
        }

        .menu-tabs::-webkit-scrollbar-track {
            background: transparent;
        }

        .menu-tab {
            font-size: 0.9rem;
            color: #666;
            cursor: pointer;
            padding-bottom: 4px;
            border-bottom: 2px solid transparent;
            transition: color 0.15s ease, border-color 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .menu-tab:hover {
            color: #333;
        }

        .menu-tab.active {
            color: #000;
            font-weight: bold;
            border-bottom-color: #AC91EB;
        }

        .display {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .display.hidden {
            display: none;
        }

        .box{
            width:100px;
            height:100px;
            border-radius:20%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .box:hover{
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .box.selected {
            outline: 3px solid #AC91EB;
            outline-offset: 2px;
        }

        .black{
            background:#D9E5FF;
        }

        .blue{
            background:#2D2F48;
        }

        .pink{
            background:#BC7773;
        }

        .white{
            background:#CDB9AC;
        }

        .yellow{
            background:#E9C490;
        }

        .box.blank {
            background: #fff;
            border: 2px dashed #bbb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 1.8rem;
            line-height: 1;
        }

        .box.blank:hover {
            border-color: #888;
            color: #888;
        }

        .box.blank.selected {
            border-color: #AC91EB;
            color: #AC91EB;
        }

        .colors {
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        .colors.hidden {
            display: none;
        }

        .colors .box {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .buttons {
            margin-top: auto;
        }

        .buttons button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #AC91EB;
            color: #fff;
            font-size: 0.95rem;
            font-weight: bold;
            cursor: pointer;
        }

        .buttons button:hover {
            background: #9a7ce0;
        }

        .buttons button:disabled {
            opacity: 0.6;
            cursor: default;
        }

        .body-container {
            width: 400px;
            height: 700px;
            border-radius: 25px;
            overflow: hidden;
            position: relative;
        }

        .body-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>

    <nav class="navbar">
        <div class="navbar-brand"></div>

        <ul class="navbar-links">
            <li><a href="home.php">Home</a></li>
        </ul>

        <div class="user-menu" id="userMenu">
            <button class="user-menu-btn" id="userMenuBtn" type="button">
                <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <span class="caret">▾</span>
            </button>
            <div class="user-menu-dropdown">
                <div class="menu-header">Signed in as <?php echo htmlspecialchars($_SESSION['user']); ?></div>
                <a href="../logout.php" class="logout-link">Log out</a>
            </div>
        </div>
    </nav>

    <div class="content">
        <div class="menu">
            <div class="menu-tabs">
                <span class="menu-tab active" data-target="body-display">body</span>
                <span class="menu-tab" data-target="eye-display">eye</span>
                <span class="menu-tab" data-target="eyebrow-display">eyebrow</span>
                <span class="menu-tab" data-target="back-display">hair</span>
                <span class="menu-tab" data-target="front-display">bangs</span>
                <span class="menu-tab" data-target="mouth-display">mouth</span>
                <span class="menu-tab" data-target="accessory-display">accessories</span>
                <span class="menu-tab" data-target="shirt-display">shirt</span>
                <span class="menu-tab" data-target="dress-display">dress</span>
                <span class="menu-tab" data-target="pant-display">pant</span>
                <span class="menu-tab" data-target="shoe-display">shoes</span>
            </div>

            <div class="display body-display" id="body-display">
                <div class="box blank" data-layer="body" data-id="0" data-asset="none" title="None">×</div>
                <?php for ($i = 1; $i < 6; $i++) { ?>
                    <div class="box black" data-layer="body" data-id="<?php echo $i ?>" data-asset="<?php echo $i ?>" style="position: relative; overflow: hidden; aspect-ratio: 1 / 1;">
                        <img src="../assets/images/body/body-<?php echo $i ?>.png" alt="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; object-position: top;">
                    </div>
                <?php } ?>
            </div>

            <div class="display eye-display hidden" id="eye-display">
                <div class="box blank" data-layer="eye" data-id="0" data-asset="none" title="None">×</div>
                <?php for ($i = 1; $i < 5; $i++) { ?>
                    <div class="box black" data-layer="eye" data-id="<?php echo $i ?>" data-asset="<?php echo $i ?>" style="position: relative; overflow: hidden;">
                        <img src="../assets/images/display/eye-<?php echo $i ?>.png" alt="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;">
                    </div>
                <?php } ?>
            </div>

            <div class="display eyebrow-display hidden" id="eyebrow-display">
                <div class="box blank" data-layer="eyebrow" data-id="0" data-asset="none" title="None">×</div>
                <?php for ($i = 1; $i < 3; $i++) { ?>
                    <div class="box black" data-layer="eyebrow" data-id="<?php echo $i ?>" data-asset="<?php echo $i ?>" style="position: relative; overflow: hidden;">
                        <img src="../assets/images/display/eyebrow-<?php echo $i ?>.png" alt="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;">
                    </div>
                <?php } ?>
            </div>

            <div class="display back-display hidden" id="back-display">
                <div class="box blank" data-layer="back" data-id="0" data-asset="none" title="None">×</div>
                <?php for ($i = 1; $i < 3; $i++) { ?>
                    <div class="box black" data-layer="back" data-id="<?php echo $i ?>" data-asset="<?php echo $i ?>" style="position: relative; overflow: hidden;">
                        <img src="../assets/images/display/back-<?php echo $i ?>.png" alt="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;">
                    </div>
                <?php } ?>
            </div>

            <div class="display front-display hidden" id="front-display">
                <div class="box blank" data-layer="front" data-id="0" data-asset="none" title="None">×</div>
                <div class="box black" data-layer="front" data-id="1" data-asset="1" style="position: relative; overflow: hidden;">
                    <img src="../assets/images/display/front-1.png" alt="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;">
                </div>
            </div>

            <div class="display mouth-display hidden" id="mouth-display">
                <div class="box blank" data-layer="mouth" data-id="0" data-asset="none" title="None">×</div>
                <?php for ($i = 1; $i < 6; $i++) { ?>
                    <div class="box black" data-layer="mouth" data-id="<?php echo $i ?>" data-asset="<?php echo $i ?>" style="position: relative; overflow: hidden;">
                        <img src="../assets/images/display/mouth-<?php echo $i ?>.png" alt="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;">
                    </div>
                <?php } ?>
            </div>

            <div class="display accessory-display hidden" id="accessory-display">
                <div class="box blank" data-layer="accessory" data-id="0" data-asset="none" title="None">×</div>
                <div class="box black" data-layer="accessory" data-id="1" data-asset="1" style="position: relative; overflow: hidden;">
                </div>
            </div>

            <div class="display shirt-display hidden" id="shirt-display">
                <div class="box blank" data-layer="shirt" data-id="0" data-asset="none" title="None">×</div>
                <div class="box black" data-layer="shirt" data-id="1" data-asset="1" style="position: relative; overflow: hidden;">
                </div>
            </div>

            <div class="display dress-display hidden" id="dress-display">
                <div class="box blank" data-layer="dress" data-id="0" data-asset="none" title="None">×</div>
                <div class="box black" data-layer="dress" data-id="1" data-asset="1" style="position: relative; overflow: hidden;">
                </div>
            </div>

            <div class="display pant-display hidden" id="pant-display">
                <div class="box blank" data-layer="pant" data-id="0" data-asset="none" title="None">×</div>
                <div class="box black" data-layer="pant" data-id="1" data-asset="1" style="position: relative; overflow: hidden;">
                </div>
            </div>

            <div class="display shoe-display hidden" id="shoe-display">
                <div class="box blank" data-layer="shoe" data-id="0" data-asset="none" title="None">×</div>
                <div class="box black" data-layer="shoe" data-id="1" data-asset="1" style="position: relative; overflow: hidden;">
                </div>
            </div>

            <div class="colors hidden" id="colorsPanel">
                <div class="box blue" data-color="blue"></div>
                <div class="box pink" data-color="pink"></div>
                <div class="box yellow" data-color="yellow"></div>
                <div class="box white" data-color="white"></div>
            </div>

            <div class="buttons">
                <button type="button" id="saveBtn">SAVE</button>
            </div>
        </div>

        <div class="body-container">
            <img class="layer-img" data-layer="back" src="../assets/images/back/back-1-blue.png" alt="">
            <img class="layer-img" data-layer="body" src="../assets/images/body/body-1.png" alt="">
            <img class="layer-img" data-layer="pant" src="" alt="" style="display: none;">
            <img class="layer-img" data-layer="shoe" src="" alt="" style="display: none;">
            <img class="layer-img" data-layer="dress" src="" alt="" style="display: none;">
            <img class="layer-img" data-layer="shirt" src="" alt="" style="display: none;">
            <img class="layer-img" data-layer="front" src="../assets/images/front/front-1-blue.png" alt="">
            <img class="layer-img" data-layer="eye" src="../assets/images/eye/eye-2-blue.png" alt="">
            <img class="layer-img" data-layer="mouth" src="../assets/images/mouth/mouth-3.png" alt="">
            <img class="layer-img" data-layer="eyebrow" src="../assets/images/eyebrow/eyebrow-1.png" alt="">
            <img class="layer-img" data-layer="accessory" src="" alt="" style="display: none;">
        </div>
    </div>

    <script>
        const userMenu = document.getElementById('userMenu');
        const userMenuBtn = document.getElementById('userMenuBtn');

        userMenuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            userMenu.classList.toggle('open');
        });

        document.addEventListener('click', function (e) {
            if (!userMenu.contains(e.target)) {
                userMenu.classList.remove('open');
            }
        });

        const colorsPanel = document.getElementById('colorsPanel');

        let activeColorLayer = null;

        function hideColorsPanel() {
            colorsPanel.classList.add('hidden');
            activeColorLayer = null;
        }

        function showColorsPanelFor(layer) {
            activeColorLayer = layer;
            colorsPanel.classList.remove('hidden');
        }

        document.querySelectorAll('.menu-tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.menu-tab').forEach(function (t) {
                    t.classList.remove('active');
                });
                tab.classList.add('active');

                document.querySelectorAll('.display').forEach(function (d) {
                    d.classList.add('hidden');
                });
                document.getElementById(tab.dataset.target).classList.remove('hidden');

                hideColorsPanel();
            });
        });

        const layerFolders = {
            eye: 'eye'
        };

        const colorableLayers = new Set(['eye', 'back', 'front']);

        function parseCurrentAsset(targetImg, layer) {
            const src = targetImg.getAttribute('src') || '';
            const filename = src.substring(src.lastIndexOf('/') + 1);
            const re = new RegExp('^' + layer + '-(\\d+)(?:-([a-zA-Z]+))?\\.png$');
            const match = filename.match(re);
            if (!match) return null;
            return { number: match[1], variant: match[2] || null };
        }

        document.querySelectorAll('.display .box').forEach(function (box) {
            box.addEventListener('click', function () {
                const layer = box.dataset.layer;
                const assetId = box.dataset.asset || box.dataset.id;
                if (!layer || !assetId) return;

                const targetImg = document.querySelector('.layer-img[data-layer="' + layer + '"]');
                if (!targetImg) return;

                if (assetId === 'none') {
                    targetImg.style.display = 'none';
                    hideColorsPanel();
                } else {
                    const folder = layerFolders[layer] || layer;

                    const match = targetImg.getAttribute('src').match(/-([a-z]+)\.png$/);
                    const variant = match ? match[1] : null;

                    targetImg.src = variant
                        ? '../assets/images/' + folder + '/' + layer + '-' + assetId + '-' + variant + '.png'
                        : '../assets/images/' + folder + '/' + layer + '-' + assetId + '.png';

                    targetImg.style.display = '';

                    if (colorableLayers.has(layer)) {
                        showColorsPanelFor(layer);
                    } else {
                        hideColorsPanel();
                    }
                }

                document.querySelectorAll('.box[data-layer="' + layer + '"]').forEach(function (b) {
                    b.classList.remove('selected');
                });
                box.classList.add('selected');
            });
        });

        document.querySelectorAll('.colors .box').forEach(function (box) {
            box.addEventListener('click', function () {
                if (!activeColorLayer) return;

                const targetImg = document.querySelector('.layer-img[data-layer="' + activeColorLayer + '"]');
                if (!targetImg) return;

                const info = parseCurrentAsset(targetImg, activeColorLayer);
                if (!info) return;

                const color = box.dataset.color;
                const folder = layerFolders[activeColorLayer] || activeColorLayer;

                targetImg.src = '../assets/images/' + folder + '/' + activeColorLayer + '-' + info.number + '-' + color + '.png';

                document.querySelectorAll('.colors .box').forEach(function (b) {
                    b.classList.remove('selected');
                });
                box.classList.add('selected');
            });
        });

        const saveBtn = document.getElementById('saveBtn');

        saveBtn.addEventListener('click', function () {
            const selections = {};

            document.querySelectorAll('.layer-img').forEach(function (img) {
                const layer = img.dataset.layer;
                const src = img.getAttribute('src') || '';
                const visible = img.style.display !== 'none';

                selections[layer] = {
                    src: visible ? src : null,
                    visible: visible
                };
            });

            saveBtn.disabled = true;
            saveBtn.textContent = 'SAVING...';

            fetch('save.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(selections)
            })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.ok) {
                        window.location.href = 'home.php';
                    } else {
                        alert('Save failed: ' + (data.error || 'unknown error'));
                        saveBtn.disabled = false;
                        saveBtn.textContent = 'SAVE';
                    }
                })
                .catch(function () {
                    alert('Save failed. Please try again.');
                    saveBtn.disabled = false;
                    saveBtn.textContent = 'SAVE';
                });
        });
    </script>
</body>
</html>