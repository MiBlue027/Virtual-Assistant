window.AI_N8N_SendMessage = function (url, message) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: url,
            type: 'POST',
            data: { message: message },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if (response.data.audio) {

                        if (window.__AI_AUDIO__) {
                            window.__AI_AUDIO__.pause();
                            window.__AI_AUDIO__.currentTime = 0;
                            window.__AI_AUDIO__ = null;
                        }

                        if (window.__AI_AUDIO_CTX__) {
                            window.__AI_AUDIO_CTX__.close();
                            window.__AI_AUDIO_CTX__ = null;
                        }

                        if (window.__AI_AUDIO_WS__) {
                            window.__AI_AUDIO_WS__.close();
                            window.__AI_AUDIO_WS__ = null;
                        }

                        if (window.__AI_AUDIO__) {
                            try {
                                window.__AI_AUDIO__.pause();
                                window.__AI_AUDIO__.src = '';
                                window.__AI_AUDIO__.load();
                            } catch (e) {}
                            window.__AI_AUDIO__ = null;
                        }

                        const audio = new Audio();
                        audio.src = response.data.audio;
                        audio.preload = 'auto';

                        audio.onended = () => {
                            window.__AI_AUDIO__ = null;
                        };

                        audio.play().catch(err => {
                            console.warn('Autoplay blocked:', err);
                        });

                        window.__AI_AUDIO__ = audio;

                        resolve({
                            text: response.data.text,
                            html: response.data.html,
                            audio: response.data.audio
                        });
                    }
                    else if (response.data.tts_endpoint)
                    {
                        try {
                            const ws = new WebSocket(response.data.tts_endpoint);
                            ws.binaryType = "arraybuffer";

                            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                            let playTime = audioCtx.currentTime;

                            ws.onopen = () => {
                                try {
                                    ws.send(JSON.stringify({
                                        ref_audio: response.data.ref_audio,
                                        ref_text:  response.data.ref_text,
                                        gen_text:  response.data.gen_text
                                    }));
                                    resolve({
                                        text: response.data.text || '',
                                        html: response.data.html || ''
                                    });
                                } catch (err) {
                                    console.error("WebSocket send error:", err);
                                    resolve({
                                        text: response.data.text,
                                        html: response.data.html,
                                        error: "The voice feature is currently under maintenance. Please continue using the chat mode."
                                    });
                                }
                            };

                            ws.onmessage = async (e) => {
                                try {
                                    const buf = await audioCtx.decodeAudioData(e.data.slice(0));
                                    const src = audioCtx.createBufferSource();
                                    src.buffer = buf;
                                    src.connect(audioCtx.destination);

                                    if (playTime < audioCtx.currentTime) {
                                        playTime = audioCtx.currentTime;
                                    }

                                    src.start(playTime);
                                    playTime += buf.duration;

                                } catch (err) {
                                    console.error("Decode error:", err);
                                    resolve({
                                        text: response.data.text,
                                        html: response.data.html,
                                        error: "The voice feature is currently under maintenance. Please continue using the chat mode."
                                    });
                                }
                            };

                            ws.onerror = (err) => {
                                console.error("WebSocket connection error:", err);
                                resolve({
                                    text: response.data.text,
                                    html: response.data.html,
                                    error: "The voice feature is currently under maintenance. Please continue using the chat mode."
                                });
                            };

                            ws.onclose = () => {
                                // Optional: handle if needed
                            };

                        } catch (err) {
                            console.error("WebSocket initialization failed:", err);
                            resolve({
                                text: response.data.text,
                                html: response.data.html,
                                error: "The voice feature is currently under maintenance. Please continue using the chat mode."
                            });
                        }
                    }
                    else {
                        if (response.error){
                            resolve({
                                text: response.data.text,
                                html: response.data.html,
                                error: response.error
                            });
                        } else {
                            resolve({
                                text: response.data.text,
                                html: response.data.html
                            });
                        }
                    }
                } else {
                    reject('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                reject('An error occurred while connecting to the server.');
                console.error("AJAX Error:", status, error);
            }
        });
    });
}