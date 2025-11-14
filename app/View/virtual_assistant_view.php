<div class="dUICChatBotContainer">
    <?php include __DIR__ . '/head_nav.php'; ?>

    <div class="dUICChatBot-MessageBoxContainerJQ dUICChatBot-MessageBoxContainer"></div>

    <div class="dUICChatBotFormContainer">
        <form id="chatBot" class="dUICChatBotFormJQ dUICChatBotForm" data-url="/ai/n8n/chat-bot-stream-tts">
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
    <div class="chatMicModeToggleJQ chatMicModeToggle">
        <div class="chatMicModeOption chatMicModeOptionChat active" data-mode="chat"> Chat</div>
        <div class="chatMicModeOption chatMicModeOptionVoice" data-mode="voice" onclick="window.location.href='/virtual-assistant-voice'"> Voice</div>
    </div>
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
