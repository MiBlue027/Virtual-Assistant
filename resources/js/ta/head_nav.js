document.addEventListener("DOMContentLoaded", function () {
    const btn = document.querySelector(".navigation-reset-btn");
    if (!btn) return;

    let pressTimer = null;
    const HOLD_TIME = 3500;

    btn.addEventListener('dblclick', (e) => e.stopPropagation());

    btn.addEventListener("mousedown", function (e) {
        e.preventDefault();
        e.stopPropagation();

        pressTimer = setTimeout(() => {
            window.location.href = "/user/logout";
        }, HOLD_TIME);
    });

    btn.addEventListener("mouseup", function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (pressTimer) {
            clearTimeout(pressTimer);
            pressTimer = null;

            window.location.href = "/user/reset/session";
        }
    });

    btn.addEventListener("mouseleave", function () {
        if (pressTimer) {
            clearTimeout(pressTimer);
            pressTimer = null;
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const elem = document.getElementById('navigation-header');

    elem.addEventListener('dblclick', function () {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.error(`Failed fullscreen: ${err.message}`);
            });
        } else {
            document.exitFullscreen().catch(err => {
                console.error(`Failed fullscreen: ${err.message}`);
            });
        }
    });
});