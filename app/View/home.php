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
            <button type="submit" class="sumChatHist-clearBtn" id="sumChatHist-clearBtnJQ">
                Clear All History
            </button>
        </form>

    </div>
</div>

