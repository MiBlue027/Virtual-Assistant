<?php
$user = $_SESSION["username"] ?? "Guest";
$isGuest = $_SESSION["isGuest"] ?? false;
?>

<header class="navigation-header" id="navigation-header">
    <div class="navigation-left">
        <?php if (!$isGuest): ?>
        <button class="navigation-menu-btn" id="navigationMenuToggle">
            <img src="/src/asset/icons/menu.svg" alt="menu">
        </button>
        <?php endif; ?>
        <img src="/src/asset/img/logo-white.png" alt="logo" class="navigation-logo">
        <h1 class="navigation-title">Virtual Assistant</h1>
    </div>
    <div class="navigation-right">
        <span class="navigation-username"> Hello, <?= htmlspecialchars($user) ?></span>
        <a href="/user/logout" class="navigation-logout-btn">Logout</a>
    </div>
</header>

<?php
if (!$isGuest):
?>
<nav class="sidebar-container" id="sidebarContainer">
    <div class="sidebar-content">
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <img src="/src/asset/icons/home.svg" alt="home" class="sidebar-icon">
                <a href="/home" class="sidebar-link">Home</a>
            </li>
            <li class="sidebar-item">
                <img src="/src/asset/icons/books.svg" alt="knowledge" class="sidebar-icon">
                <a href="/va/knowledge/list" class="sidebar-link">Knowledge Base</a>
            </li>
            <li class="sidebar-item">
                <img src="/src/asset/icons/robot.svg" alt="virtual assistant" class="sidebar-icon">
                <a href="/virtual-assistant" class="sidebar-link">Virtual Assistant</a>
            </li>
        </ul>
    </div>
</nav>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const menuBtn = document.getElementById("navigationMenuToggle");
        const sidebar = document.getElementById("sidebarContainer");
        const overlay = document.getElementById("sidebarOverlay");

        menuBtn.addEventListener("click", () => {
            sidebar.classList.toggle("sidebar-open");
            overlay.classList.toggle("sidebar-show");
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.remove("sidebar-open");
            overlay.classList.remove("sidebar-show");
        });
    });
</script>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const elem = document.getElementById('navigation-header');

        elem.addEventListener('dblclick', function () {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.error(`Gagal masuk fullscreen: ${err.message}`);
                });
            } else {
                document.exitFullscreen().catch(err => {
                    console.error(`Gagal keluar fullscreen: ${err.message}`);
                });
            }
        });
    });
</script>
