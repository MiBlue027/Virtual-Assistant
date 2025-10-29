$(document).ready(function () {

    const SR = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SR) {
        console.error("SpeechRecognition is not supported in this browser");
        // window.SpeechToText = function () {
        //     alert("SpeechRecognition is not supported in this browser");
        // };
        return;
    }

    let activeRecognition = null;

    window.SpeechToText = function ({
        lang = "id-ID",
        interim = false,
        continuous = false,
        onResult,
        onEnd,
        onError
    }) {
        if (activeRecognition) {
            try { activeRecognition.stop(); } catch(e){}
        }

        const recognition = new SR();
        recognition.lang = lang;
        recognition.interimResults = interim;
        recognition.continuous = continuous;

        recognition.onresult = e => {
            let text = "";
            for (let i = e.resultIndex; i < e.results.length; ++i) {
                text += e.results[i][0].transcript;
            }
            if (typeof onResult === "function") onResult(text.trim(), e);
        };

        recognition.onerror = e => {
            if (typeof onError === "function") onError(e);
            else console.error("SpeechRecognition Error:", e.error);
        };

        recognition.onend = () => {
            activeRecognition = null;
            if (typeof onEnd === "function") onEnd();
        };

        recognition.start();
        activeRecognition = recognition;
        return recognition;
    };

    window.SpeechToText.stop = function () {
        if (activeRecognition) {
            try { activeRecognition.stop(); } catch(e){}
            activeRecognition = null;
        }
    };

});