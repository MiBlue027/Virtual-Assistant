window.AudioCtx = new (window.AudioContext || window.webkitAudioContext)();

const bubble = document.querySelector(".voiceBubble");

bubble.addEventListener("click", function() {
    if (bubble.classList.contains("listening")) {
        window.SpeechToText.stop();
        resetBubble();
        return;
    }

    startListening();
});

function startListening() {
    bubble.classList.add("listening");
    bubble.setAttribute("data-listening", "true");

    window.SpeechToText({
        lang: "en-EN",
        interim: false,
        continuous: false,
        onResult: (text) => {
            if (text.trim() !== "") {
                resetBubble();
                sendVoiceRequest("/ai/n8n/chat-bot-stream-tts", text);
            }
        },
        onEnd: resetBubble,
        onError: (err) => {
            console.error("STT Error:", err);
            resetBubble();
        }
    });
}

function resetBubble() {
    bubble.classList.remove("listening");
    bubble.setAttribute("data-listening", "false");
}

function sendVoiceRequest(url, message) {
    AI_N8N_SendMessage(url, message)
        .then(function(data) {
            if (data.audio) {
                playAndAnimateBubble(data.audio);
            }
            else if (data.tts_endpoint) {
                playAndAnimateStream(data.tts_endpoint, data);
            }
        })
        .catch(function(err) {
            console.error("Voice Assistant Error:", err);
            showChatMicErrorModal("Sorry, our service is currently unavailable. please contact your administrator")
        });
}

function playAndAnimateBubble(audioUrl) {
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
        .catch(e => console.log("Autoplay blocked"));

    audio.onended = () => {
        bubble.classList.remove("speaking");
        bubble.style.transform = "scale(1)";
    };
}

function playAndAnimateStream(ttsEndpoint, data) {
    bubble.classList.add("speaking");

    const ws = new WebSocket(ttsEndpoint);
    ws.binaryType = "arraybuffer";
    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    const analyser = audioCtx.createAnalyser();
    analyser.fftSize = 256;
    const dataArray = new Uint8Array(analyser.frequencyBinCount);

    let playTime = audioCtx.currentTime;

    ws.onopen = () => {
        ws.send(JSON.stringify({
            ref_audio: data.ref_audio,
            ref_text:  data.ref_text,
            gen_text:  data.gen_text
        }));
    };

    ws.onmessage = async (e) => {
        try {
            const buf = await audioCtx.decodeAudioData(e.data.slice(0));
            const src = audioCtx.createBufferSource();
            src.buffer = buf;
            src.connect(analyser);
            analyser.connect(audioCtx.destination);

            if (playTime < audioCtx.currentTime)
                playTime = audioCtx.currentTime;

            src.start(playTime);
            playTime += buf.duration;

            animate();

            function animate() {
                requestAnimationFrame(animate);
                analyser.getByteFrequencyData(dataArray);
                const avg = dataArray.reduce((a,b)=>a+b,0)/dataArray.length;
                const scale = 1 + avg / 300;
                bubble.style.transform = `scale(${scale})`;
            }

            src.onended = () => {
                bubble.classList.remove("speaking");
                bubble.style.transform = "scale(1)";
            };

        } catch (err) {
            console.error("Decode error:", err);
            bubble.classList.remove("speaking");
        }
    };
}

function showChatMicErrorModal(message = "Terjadi kesalahan, silakan coba lagi.") {
    const modal = document.querySelector(".chatMicErrorModalJQ");
    const msg = modal.querySelector(".chatMicErrorModalMessage");
    msg.textContent = message;
    modal.classList.add("show");
}

document.querySelector(".chatMicErrorModalCloseBtnJQ").addEventListener("click", () => {
    document.querySelector(".chatMicErrorModalJQ").classList.remove("show");
});


