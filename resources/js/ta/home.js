$(document).ready(function () {

    const gauge = $('#sumChatHist-gaugeJQ');
    const label = $('#sumChatHist-gaugeLabelJQ');

    if (gauge.data('used') === "Error"){
        label.text(`Error!`);
        return
    }

    const maxChats = parseInt(gauge.data('total'));
    const currentChats = parseInt(gauge.data('used'));

    const percent = currentChats / maxChats;
    const angle = percent * 360; // full circle

    let color = "#4caf50";
    if (percent >= 0.66) color = "#f44336";
    else if (percent >= 0.33) color = "#ffc107";

    gauge.css("background", `conic-gradient(
        ${color} ${angle}deg,
        #ddd ${angle}deg 360deg
    )`);

    if (currentChats > 999) {
        label.text(`999+ / ${maxChats}`);
    } else {
        label.text(`${currentChats} / ${maxChats}`);
    }

});
