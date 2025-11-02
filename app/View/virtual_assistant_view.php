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
</div>
