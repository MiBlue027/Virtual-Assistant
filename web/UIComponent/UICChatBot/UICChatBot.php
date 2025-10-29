<?php

namespace UIC\UICChatBot;

use App\Constant\GeneralConstant\IconNameConstant;

class UICChatBot
{
    public function __construct()
    {
    }
    
    public function Render(
            string $id
            , string $n8nUrl
            , string $height
            , string $width = "100%"
            , string $typingPlaceholder = "How can I help you?"
            , bool $isStt = false
            , string $sttLang = "en-EN"
            , bool $sttAutoSubmit = false
            , string $class = "")
    {
        ?>
        <div class="dUICChatBotContainer" style="width: <?= $width ?>; height: <?= $height ?>">
            <div class="dUICChatBot-MessageBoxContainerJQ dUICChatBot-MessageBoxContainer"></div>
            <div class="dUICChatBotFormContainer">
                <form id="<?= $id ?>" class="dUICChatBotFormJQ dUICChatBotForm <?= $class ?>" data-url="<?= $n8nUrl ?>">
                    <label for="txaUICChatBot_<?= $id ?>"></label>
                    <textarea id="txaUICChatBot_<?= $id ?>" placeholder="<?= $typingPlaceholder ?>" rows="1" class="txaUicChatBotJQ txaUicChatBot"></textarea>
                    <button class="btnUICChatBot-SendMessage" type="submit">
                        <img src="/src/asset/icons/send-solid1.svg" alt="">
                    </button>
                    <?php if  ($isStt): ?>
                        <button class="btnUICChatBot-STT-JQ btnUICChatBot-STT" type="button">
                            <img src="/src/asset/icons/mic-off-solid1.svg"
                                 alt="" data-lang="<?= $sttLang ?>"
                                 data-mic-on="/src/asset/icons/mic-on-solid1.svg"
                                 data-mic-off="/src/asset/icons/mic-off-solid1.svg"
                                 data-auto-submit="<?= $sttAutoSubmit ?>"
                            >
                        </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <?php
    }
}