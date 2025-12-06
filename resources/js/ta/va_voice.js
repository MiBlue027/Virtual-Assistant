// Audio Context Setup
const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
const analyser = audioCtx.createAnalyser();
analyser.fftSize = 256;
const dataArray = new Uint8Array(analyser.frequencyBinCount);
analyser.connect(audioCtx.destination);

// Global state
let currentWebSocket = null;
let currentAudio = null;
let animating = false;
let currentAudioSources = [];

// Initialize particles
function initParticles() {
    const container = document.getElementById('va_voice-particles');
    if (!container) return;

    for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        particle.className = 'va_voice-particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDuration = (Math.random() * 10 + 5) + 's';
        particle.style.animationDelay = Math.random() * 5 + 's';
        container.appendChild(particle);
    }
}

// Update UI state
function updateUIState(state) {
    const bubble = document.querySelector('.voiceBubble');
    const statusBadge = document.getElementById('va_voice-statusBadge');
    const micLabel = document.getElementById('va_voice-micLabel');
    const waveIndicator = document.getElementById('va_voice-waveIndicator');

    // Remove all states
    bubble.classList.remove('listening', 'speaking');
    statusBadge.classList.remove('listening', 'speaking');
    waveIndicator.classList.remove('active');

    // Apply new state
    switch(state) {
        case 'idle':
            statusBadge.textContent = 'Idle';
            micLabel.textContent = 'Click to speak';
            bubble.setAttribute('data-listening', 'false');
            break;
        case 'listening':
            bubble.classList.add('listening');
            statusBadge.classList.add('listening');
            statusBadge.textContent = 'Listening';
            micLabel.textContent = 'Listening...';
            bubble.setAttribute('data-listening', 'true');
            break;
        case 'speaking':
            bubble.classList.add('speaking');
            statusBadge.classList.add('speaking');
            statusBadge.textContent = 'Speaking';
            micLabel.textContent = 'Speaking...';
            waveIndicator.classList.add('active');
            break;
    }
}

// Update message display
function updateMessage(text) {
    const messageText = document.getElementById('va_voice-messageText');
    if (messageText && text) {
        messageText.textContent = text;
    }
}

// Stop all active audio
function stopAllAudio() {
    // Stop websocket
    if (currentWebSocket) {
        currentWebSocket.close();
        currentWebSocket = null;
    }

    // Stop audio element
    if (currentAudio) {
        currentAudio.pause();
        currentAudio.currentTime = 0;
        currentAudio = null;
    }

    // Stop all audio sources
    currentAudioSources.forEach(source => {
        try {
            source.stop();
        } catch (e) {
            // Source might already be stopped
        }
    });
    currentAudioSources = [];

    // Stop animation
    animating = false;
}

// Reset to idle state
function resetBubble(bubble) {
    stopAllAudio();
    updateUIState('idle');
    bubble.style.transform = 'scale(1)';
}

// Handle bubble click
document.addEventListener("click", function (e) {
    const bubble = e.target.closest(".voiceBubble");
    if (!bubble) return;

    if (bubble.classList.contains("listening") || bubble.classList.contains("speaking")) {
        if (window.SpeechToText && typeof window.SpeechToText.stop === "function") {
            window.SpeechToText.stop();
        }
        resetBubble(bubble);
        return;
    }

    startListening(bubble);
});

// Start listening
function startListening(bubble) {
    // Stop any current audio before starting new session
    stopAllAudio();

    updateUIState('listening');

    if (!window.SpeechToText) {
        console.warn("SpeechToText engine not found");
        resetBubble(bubble);
        return;
    }

    window.SpeechToText({
        lang: "id-ID",
        interim: false,
        continuous: false,
        onResult: (text) => {
            resetBubble(bubble);
            sendVoiceRequest("/ai/n8n/chat-bot-stream-tts", text);
        },
        onEnd: () => {
            resetBubble(bubble);
        },
        onError: (err) => {
            console.error("STT Error:", err);
            resetBubble(bubble);
        }
    });
}

// Send voice request
function sendVoiceRequest(url, message) {
    if (typeof AI_N8N_SendMessage !== "function") {
        console.error("AI_N8N_SendMessage() is not defined");
        return;
    }

    AI_N8N_SendMessage(url, message)
        .then(function (data) {
            // Update message text if available
            if (data.html) {
                updateMessage(data.html);
            }

            if (data.audio) {
                const bubble = document.querySelector(".voiceBubble");
                playAndAnimateBubble(bubble, data.audio);
            } else if (data.tts_endpoint) {
                const bubble = document.querySelector(".voiceBubble");
                playAndAnimateStream(bubble, data.tts_endpoint, data);
            }

            if (data.error) {
                showFallbackNotif(data.error, "error");
            }
        })
        .catch(function (err) {
            console.error("Voice Assistant Error:", err);
            showChatMicErrorModal("Sorry, our service is currently unavailable. Please contact your administrator");
        });
}

// Play audio with animation
function playAndAnimateBubble(bubble, audioUrl) {
    stopAllAudio(); // Stop any current audio
    updateUIState('speaking');

    currentAudio = new Audio(audioUrl);
    const src = audioCtx.createMediaElementSource(currentAudio);
    const analyser = audioCtx.createAnalyser();

    src.connect(analyser);
    analyser.connect(audioCtx.destination);
    analyser.fftSize = 256;

    const bufferLength = analyser.frequencyBinCount;
    const dataArray = new Uint8Array(bufferLength);

    function animate() {
        if (!currentAudio || currentAudio.paused) return;

        requestAnimationFrame(animate);
        analyser.getByteFrequencyData(dataArray);
        let avg = dataArray.reduce((a, b) => a + b, 0) / bufferLength;
        let scale = 1 + avg / 300;
        bubble.style.transform = `scale(${scale})`;
    }

    currentAudio.play()
        .then(() => animate())
        .catch(() => console.log("Autoplay blocked"));

    currentAudio.onended = () => resetBubble(bubble);
}

// Play streaming audio with animation
function playAndAnimateStream(bubble, ttsEndpoint, data) {
    stopAllAudio(); // Stop any current audio
    updateUIState('speaking');
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

    currentWebSocket = new WebSocket(ttsEndpoint);
    currentWebSocket.binaryType = "arraybuffer";

    let playTime = audioCtx.currentTime;

    currentWebSocket.onmessage = async (e) => {
        if (!animating) return; // Don't process if stopped

        const arrayBuffer = e.data instanceof Blob ? await e.data.arrayBuffer() : e.data;
        const buf = await audioCtx.decodeAudioData(arrayBuffer);
        const src = audioCtx.createBufferSource();
        src.buffer = buf;
        src.connect(analyser);

        currentAudioSources.push(src);

        if (playTime < audioCtx.currentTime) playTime = audioCtx.currentTime;
        src.start(playTime);
        playTime += buf.duration;

        src.onended = () => {
            // Remove from active sources
            const index = currentAudioSources.indexOf(src);
            if (index > -1) {
                currentAudioSources.splice(index, 1);
            }

            if (currentWebSocket && currentWebSocket.readyState === WebSocket.CLOSED && currentAudioSources.length === 0) {
                animating = false;
                resetBubble(bubble);
            }
        };
    };

    currentWebSocket.onclose = () => {
        if (currentAudioSources.length === 0) {
            animating = false;
            resetBubble(bubble);
        }
    };

    currentWebSocket.onerror = () => {
        animating = false;
        resetBubble(bubble);
    };
}

// Show error modal
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

// Close modal
document.addEventListener("click", function (e) {
    if (e.target.closest(".chatMicErrorModalCloseBtnJQ")) {
        const modal = document.querySelector(".chatMicErrorModalJQ");
        if (modal) modal.classList.remove("show");
    }
});

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    initParticles();
    updateUIState('idle');
});