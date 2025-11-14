const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
const analyser = audioCtx.createAnalyser();
analyser.fftSize = 256;
const dataArray = new Uint8Array(analyser.frequencyBinCount);
analyser.connect(audioCtx.destination);

document.addEventListener("click", function (e) {
    const bubble = e.target.closest(".voiceBubble");
    if (!bubble) return;

    if (bubble.classList.contains("listening")) {
        if (window.SpeechToText && typeof window.SpeechToText.stop === "function") {
            window.SpeechToText.stop();
        }
        resetBubble(bubble);
        return;
    }

    startListening(bubble);
});

function startListening(bubble) {
    bubble.classList.add("listening");
    bubble.setAttribute("data-listening", "true");

    if (!window.SpeechToText) {
        console.warn("SpeechToText engine not found");
        resetBubble(bubble);
        return;
    }

    window.SpeechToText({
        lang: "en-EN",
        interim: false,
        continuous: false,
        onResult: (text) => {
            if (text.trim() !== "") {
                resetBubble(bubble);
                sendVoiceRequest("/ai/n8n/chat-bot-stream-tts", text);
            }
        },
        onEnd: () => resetBubble(bubble),
        onError: (err) => {
            console.error("STT Error:", err);
            resetBubble(bubble);
        }
    });
}

function resetBubble(bubble) {
    bubble.classList.remove("listening", "speaking");
    bubble.setAttribute("data-listening", "false");
    bubble.style.transform = "scale(1)";
}

function sendVoiceRequest(url, message) {
    if (typeof AI_N8N_SendMessage !== "function") {
        console.error("AI_N8N_SendMessage() is not defined");
        return;
    }

    AI_N8N_SendMessage(url, message)
        .then(function (data) {
            if (data.audio) {
                const bubble = document.querySelector(".voiceBubble");
                playAndAnimateBubble(bubble, data.audio);
            } else if (data.tts_endpoint) {
                const bubble = document.querySelector(".voiceBubble");
                playAndAnimateStream(bubble, data.tts_endpoint, data);
            }
            if (data.error){
                showFallbackNotif(data.error, "error");
            }
        })
        .catch(function (err) {
            console.error("Voice Assistant Error:", err);
            showChatMicErrorModal("Sorry, our service is currently unavailable. Please contact your administrator");
        });
}

function playAndAnimateBubble(bubble, audioUrl) {
    bubble.classList.add("speaking");

    const audio = new Audio(audioUrl);
    const src = window.AudioCtx.createMediaElementSource(audio);
    const analyser = window.AudioCtx.createAnalyser();

    src.connect(analyser);
    analyser.connect(window.AudioCtx.destination);
    analyser.fftSize = 256;

    const bufferLength = analyser.frequencyBinCount;
    const dataArray = new Uint8Array(bufferLength);

    function animate() {
        requestAnimationFrame(animate);
        analyser.getByteFrequencyData(dataArray);
        let avg = dataArray.reduce((a, b) => a + b, 0) / bufferLength;
        let scale = 1 + avg / 300;
        bubble.style.transform = `scale(${scale})`;
    }

    audio.play()
        .then(() => animate())
        .catch(() => console.log("Autoplay blocked"));

    audio.onended = () => resetBubble(bubble);
}

let animating = false;

function playAndAnimateStream(bubble, ttsEndpoint, data) {
    bubble.classList.add("speaking");
    animating = true;

    function animate() {
        if (!animating) return;
        requestAnimationFrame(animate);
        analyser.getByteFrequencyData(dataArray);
        const avg = dataArray.reduce((a, b) => a + b, 0) / dataArray.length;
        const scale = 1 + (avg / 255) * 0.8;
        bubble.style.transform = `scale(${scale})`;
    }
    animate();

    const ws = new WebSocket(ttsEndpoint);
    ws.binaryType = "arraybuffer";

    let playTime = audioCtx.currentTime;

    ws.onmessage = async (e) => {
        const arrayBuffer = e.data instanceof Blob ? await e.data.arrayBuffer() : e.data;
        const buf = await audioCtx.decodeAudioData(arrayBuffer);
        const src = audioCtx.createBufferSource();
        src.buffer = buf;
        src.connect(analyser); // semua source lewat analyser

        if (playTime < audioCtx.currentTime) playTime = audioCtx.currentTime;
        src.start(playTime);
        playTime += buf.duration;

        src.onended = () => {
            if (ws.readyState === WebSocket.CLOSED) {
                animating = false;
                resetBubble(bubble);
            }
        };
    };

    ws.onclose = () => {
        animating = false;
        resetBubble(bubble);
    };

    ws.onerror = () => {
        animating = false;
        resetBubble(bubble);
    };
}


function showChatMicErrorModal(message = "Sorry, our voice feature is currently under maintenance. Please continue using chat mode.") {
    const modal = document.querySelector(".chatMicErrorModalJQ");
    if (!modal) {
        console.warn("chatMicErrorModalJQ not found");
        return;
    }

    const msg = modal.querySelector(".chatMicErrorModalMessage");
    if (msg) msg.textContent = message;
    modal.classList.add("show");
}

document.addEventListener("click", function (e) {
    if (e.target.closest(".chatMicErrorModalCloseBtnJQ")) {
        const modal = document.querySelector(".chatMicErrorModalJQ");
        if (modal) modal.classList.remove("show");
    }
});
