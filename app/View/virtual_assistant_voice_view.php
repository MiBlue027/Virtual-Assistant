<?php include __DIR__ . '/head_nav.php'; ?>
<div class="voiceAssistantContainer">
    <div class="voiceBubbleContainer">
        <div class="voiceBubble" data-listening="false">
            <div class="voicePulse"></div>
        </div>
    </div>
</div>
<div class="chatMicErrorModalJQ chatMicErrorModal">
    <div class="chatMicErrorModalOverlay"></div>
    <div class="chatMicErrorModalBox">
        <div class="chatMicErrorModalContent">
            <h3 class="chatMicErrorModalTitle">Notification</h3>
            <p class="chatMicErrorModalMessage">Err.</p>
            <button class="chatMicErrorModalCloseBtnJQ chatMicErrorModalCloseBtn">OK</button>
        </div>
    </div>
</div>
<div class="chatMicModeToggleJQ chatMicModeToggle">
    <div class="chatMicModeOption chatMicModeOptionChat" data-mode="chat" onclick="window.location.href='/virtual-assistant'"> Chat</div>
    <div class="chatMicModeOption chatMicModeOptionVoice active" data-mode="voice"> Voice</div>
</div>

<div class="vafallbacknotif-container" id="vafallbacknotif">
    <div class="vafallbacknotif-message"></div>
</div>

<script>
    function showFallbackNotif(message, type = "error") {
        const notif = document.getElementById("vafallbacknotif");
        const msgBox = notif.querySelector(".vafallbacknotif-message");

        notif.className = `vafallbacknotif-container ${type}`;
        msgBox.textContent = message;

        notif.style.display = "block";
        notif.style.opacity = "1";

        clearTimeout(notif.hideTimeout);
        notif.hideTimeout = setTimeout(() => hideFallbackNotif(), 10000);

        notif.onclick = hideFallbackNotif;
    }

    function hideFallbackNotif() {
        const notif = document.getElementById("vafallbacknotif");
        notif.style.opacity = "0";
        setTimeout(() => {
            notif.style.display = "none";
        }, 300);
    }
</script>