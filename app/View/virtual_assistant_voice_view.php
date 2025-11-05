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
