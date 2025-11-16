<?php include __DIR__ . '/head_nav.php';

$totalChat = $model["totalChat"] ?? 0;

?>

<div class="sumChatHist-container">
    <div class="sumChatHist-card">
        <h2 class="sumChatHist-title">Chat History Summary</h2>

        <div class="sumChatHist-gaugeWrapper">
            <div class="sumChatHist-gaugeCore">
                <div class="sumChatHist-gaugeArc"
                     data-total="999"
                     data-used="<?= $totalChat ?>"
                     id="sumChatHist-gaugeJQ"></div>

                <div class="sumChatHist-gaugeCenter">
                    <span id="sumChatHist-gaugeLabelJQ">0 / 999</span>
                </div>
            </div>
        </div>
        <form action="/home" method="POST">
            <button type="button" class="sumChatHist-clearBtn" id="sumChatHist-clearBtnJQ">
                Clear All History
            </button>
        </form>

    </div>
</div>

<div class="sumChatHist-modal" id="sumChatHist-modal">
    <div class="sumChatHist-modalBox">
        <p>Are you sure you want to clear all chat history?</p>
        <div class="sumChatHist-modalActions">
            <button id="sumChatHist-confirm">Yes</button>
            <button id="sumChatHist-cancel">Cancel</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const btnClear = document.getElementById("sumChatHist-clearBtnJQ");
        const modal = document.getElementById("sumChatHist-modal");
        const btnConfirm = document.getElementById("sumChatHist-confirm");
        const btnCancel = document.getElementById("sumChatHist-cancel");
        const form = document.getElementById("sumChatHist-form");

        btnClear.addEventListener("click", () => {
            modal.style.display = "flex";
        });

        btnCancel.addEventListener("click", () => {
            modal.style.display = "none";
        });

        btnConfirm.addEventListener("click", () => {
            form.submit();
        });
    });
</script>

