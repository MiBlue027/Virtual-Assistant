<?php include __DIR__ . '/head_nav.php'; ?>

<div class="voiceAssistantContainer">
    <!-- Particle Background -->
    <div class="va_voice-particles" id="va_voice-particles"></div>

    <!-- Main Card -->
    <div class="va_voice-card">
        <div class="va_voice-card-header">
            <h2 class="va_voice-card-title">Virtual Voice Assistant</h2>
            <span class="va_voice-status-badge" id="va_voice-statusBadge">Idle</span>
        </div>

        <div class="va_voice-card-body">
            <!-- Mic Button Container -->
            <div class="va_voice-mic-container">
                <div class="voiceBubble" data-listening="false">
                    <div class="va_voice-mic-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path>
                            <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                            <line x1="12" y1="19" x2="12" y2="22"></line>
                        </svg>
                    </div>
                    <div class="va_voice-pulse-ring"></div>
                    <div class="va_voice-pulse-ring va_voice-pulse-ring-2"></div>
                </div>
                <p class="va_voice-mic-label" id="va_voice-micLabel">Click to speak</p>
            </div>

            <!-- Message Display -->
            <div class="va_voice-message-container">
                <div class="va_voice-message-bubble" id="va_voice-messageBubble">
                    <p class="va_voice-message-text" id="va_voice-messageText">
                        Hello, I'm Mei, Ma Chung University's Virtual Assistant, ready to help you. Don't hesitate to ask!
                    </p>
                </div>
            </div>
        </div>

        <div class="va_voice-card-footer">
            <div class="va_voice-wave-indicator" id="va_voice-waveIndicator">
                <div class="va_voice-wave-bar"></div>
                <div class="va_voice-wave-bar"></div>
                <div class="va_voice-wave-bar"></div>
                <div class="va_voice-wave-bar"></div>
                <div class="va_voice-wave-bar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
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

<!-- Mode Toggle -->
<div class="chatMicModeToggleJQ chatMicModeToggle va_voice-mode-toggle">
    <div class="chatMicModeOption chatMicModeOptionChat va_voice-mode-option" data-mode="chat" onclick="window.location.href='/virtual-assistant'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        Chat
    </div>
    <div class="chatMicModeOption chatMicModeOptionVoice active va_voice-mode-option" data-mode="voice">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path>
            <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
        </svg>
        Voice
    </div>
</div>

<!-- Fallback Notification -->
<div class="vafallbacknotif-container va_voice-fallback-notif" id="vafallbacknotif">
    <div class="vafallbacknotif-message"></div>
</div>

<script>
    console.log("<?= $_SESSION["guestId"] ?? "no id" ?>")

    function showFallbackNotif(message, type = "error") {
        const notif = document.getElementById("vafallbacknotif");
        const msgBox = notif.querySelector(".vafallbacknotif-message");

        notif.className = `vafallbacknotif-container va_voice-fallback-notif ${type}`;
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