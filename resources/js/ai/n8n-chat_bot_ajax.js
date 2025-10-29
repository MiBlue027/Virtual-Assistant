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
                        let audio = new Audio(response.data.audio);
                        audio.play().catch(e => {
                            console.log('Autoplay prevented - user needs to interact first');
                        });

                        resolve({
                            text: response.data.text,
                            html: response.data.html,
                            audio: response.data.audio
                        });
                    }
                    else if (response.data.tts_endpoint)
                    {
                        const ws = new WebSocket(response.data.tts_endpoint);
                        ws.binaryType = "arraybuffer";

                        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                        let playTime = audioCtx.currentTime;

                        ws.onopen = () => {
                            ws.send(JSON.stringify({
                                ref_audio: response.data.ref_audio,
                                ref_text:  response.data.ref_text,
                                gen_text:  response.data.gen_text
                            }));
                            resolve({
                                text: response.data.text || '',
                                html: response.data.html || ''
                            });
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
                            }
                        };

                        ws.onclose = () => {
                            // Nothing
                        };
                    }
                    else {
                        resolve({
                            text: response.data.text,
                            html: response.data.html
                        });
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