<h1>AI Agent Chat</h1>
<?php

use Path\RoutePath;
use UIC\UICChatBot\UICChatBot;

$uicChatBot = new UICChatBot();
$uicChatBot->Render("chatBot", "/ai/n8n/chat-bot-stream-tts", height: "30em", isStt: true);

?>
