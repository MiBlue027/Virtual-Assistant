<div class="dUICChatBotContainer">
    <?php include __DIR__ . '/head_nav.php'; ?>

    <div class="va_voice-particles" id="va_voice-particles"></div>

    <div class="dUICChatBot-MessageBoxContainerJQ dUICChatBot-MessageBoxContainer"></div>

    <div class="dUICChatBotFormContainer">
        <form id="chatBot" class="dUICChatBotFormJQ dUICChatBotForm" data-url="/ai/n8n/chat-bot">
            <label for="txaUICChatBot_chatBot"></label>
            <textarea id="txaUICChatBot_chatBot" placeholder="How can I Help you?" rows="1" class="txaUicChatBotJQ txaUicChatBot"></textarea>
            <button class="btnUICChatBot-SendMessage" type="submit">
                <img src="/src/asset/icons/send-solid1.svg" alt="">
            </button>
            <button class="btnUICChatBot-STT-JQ btnUICChatBot-STT" type="button">
                <img src="/src/asset/icons/mic-off-solid1.svg"
                     alt="" data-lang="en-EN"
                     data-mic-on="/src/asset/icons/mic-on-solid1.svg"
                     data-mic-off="/src/asset/icons/mic-off-solid1.svg"
                     data-auto-submit="true"
                >
            </button>
        </form>
    </div>
</div>

<div class="chatMicModeToggleJQ chatMicModeToggle va_voice-mode-toggle">
    <div class="chatMicModeOption chatMicModeOptionChat active va_voice-mode-option" data-mode="chat">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        Chat
    </div>
    <div class="chatMicModeOption chatMicModeOptionVoice va_voice-mode-option" data-mode="voice" onclick="window.location.href='/virtual-assistant-voice'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path>
            <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
        </svg>
        Voice
    </div>
</div>

<div class="vafallbacknotif-container" id="vafallbacknotif">
    <div class="vafallbacknotif-message"></div>
</div>

<script>
    console.log("<?= $_SESSION["guestId"] ?? "no id" ?>")

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
