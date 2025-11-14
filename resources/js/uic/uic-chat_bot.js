$(document).on("input", ".txaUicChatBotJQ", function (){
    this.style.height = "auto";
    this.style.height = (this.scrollHeight) + "px";
});

$(document).on("submit", ".dUICChatBotFormJQ", function(e) {
    e.preventDefault();

    if (window.AudioCtx.state === "suspended") {
        window.AudioCtx.resume();
    }

    let textAreaTarget = $(this).find(".txaUicChatBotJQ");
    let message = textAreaTarget.val();

    if (message.trim() === '') return;

    let chatBox = $(this)
        .closest(".dUICChatBotContainer")
        .find(".dUICChatBot-MessageBoxContainerJQ");

    let messageBox = $('<div>').addClass('dUICChatBot-Message dUICChatBot-User');
    let messageUsername = $("<p>").addClass("dUICChatBot-Username").text("You");
    let messageContent = $('<div>').addClass("dUICChatBot-Bubble").text(message.trim());

    messageBox.append(messageUsername, messageContent);
    chatBox.append(messageBox);
    chatBox.scrollTop(chatBox[0].scrollHeight);

    let url = $(this).data("url");

    AI_N8N_SendMessage(url, message)
        .then(function(data) {
            let aiBox = $('<div>').addClass('dUICChatBot-Message dUICChatBot-AI');
            let aiName = $("<p>").addClass("dUICChatBot-Username").text("AI");
            let aiContent = $('<div>').addClass("dUICChatBot-Bubble").html(data.html);

            aiBox.append(aiName, aiContent);
            chatBox.append(aiBox);
            chatBox.scrollTop(chatBox[0].scrollHeight);

            if (data.error){
                showFallbackNotif(data.error, "error");
            }

        })
        .catch(function(error) {
            console.error("AI Error:", error);

            let errorBox = $('<div>').addClass('dUICChatBot-Message dUICChatBot-AI');
            let errorContent = $('<div>')
                .addClass("dUICChatBot-Bubble")
                .css("color", "red")
                .text("⚠️ Error: " + error);

            errorBox.append(errorContent);
            chatBox.append(errorBox);
        });

    textAreaTarget.val("");
    textAreaTarget.css("height", "auto");
    textAreaTarget.focus();
});

$(document).on("keydown", ".txaUicChatBotJQ", function(e) {
    if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        $(this).closest(".dUICChatBotFormJQ").submit();
    }
});

// region SPEECH TO TEXT HANDLER
$(document).on("click", ".btnUICChatBot-STT-JQ", function (){
    const sttBtn = $(this);
    const sttLang = sttBtn.data("lang")
    const sttImg = sttBtn.find("img");
    const micOnIcon  = sttImg.data("mic-on");
    const micOffIcon = sttImg.data("mic-off");
    const autoSubmit = sttImg.data("auto-submit");
    const form = sttBtn.closest("form");
    const chatTextArea = $(this).closest("form").find(".txaUicChatBotJQ");

    if (sttBtn.hasClass("is-recording")) {
        window.SpeechToText.stop();
        resetMic();
        return;
    }

    sttBtn.addClass("is-recording");
    sttImg.attr("src", micOnIcon);

    window.SpeechToText({
        lang: sttLang,
        interim: false,
        continuous: false,
        onResult: (text) => {
            chatTextArea.val(text);
        },
        onEnd: () => {
            resetMic();
            if (autoSubmit && $.trim(chatTextArea.val()) !== "") {
                form.trigger("submit");
            }
        },
        onError: (err) => {
            alert("Error: " + err.error);
            resetMic();
        }
    });

    function resetMic() {
        sttBtn.removeClass("is-recording");
        sttImg.attr("src", micOffIcon);
        chatTextArea.focus();
    }
});
// endregion
