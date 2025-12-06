<?php include __DIR__ . '/head_nav.php';

$totalChat = $model["totalChat"] ?? 0;
$listKnowledgeQst = $model["listKnowledgeQst"] ?? null;
$listUnknowledgeQst = $model["listUnknowledgeQst"] ?? null;
?>

<div class="sumChatHist-container">
    <div class="sumChatHist-card">
        <h2 class="sumChatHist-title">Count Chat History</h2>

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
        <form action="/home" method="POST" id="sumChatHist-form">
            <button type="button" class="sumChatHist-clearBtn" id="sumChatHist-clearBtnJQ">
                Clear All History
            </button>
        </form>

    </div>
</div>

<div class="sumChatHist-summaryCard">
    <h3 class="sumChatHist-summaryTitle">Most Asked Questions</h3>

    <div class="sumChatHist-summaryTableWrapper">
        <table class="sumChatHist-summaryTable">
            <thead>
            <tr>
                <th>No</th>
                <th>Question</th>
                <th>Count</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if ($listKnowledgeQst):
                    for ($i = 0; $i < count($listKnowledgeQst); $i++):
            ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= htmlspecialchars($listKnowledgeQst[$i]['question']) ?></td>
                        <td><?= $listKnowledgeQst[$i]['qty'] ?></td>
                    </tr>
            <?php
                    endfor;
                endif;
            ?>
            </tbody>
        </table>
    </div>

<!--    <div class="sumChatHist-summaryAction">-->
<!--        <a href="/detail/questions" class="sumChatHist-detailBtn">Detail</a>-->
<!--    </div>-->
</div>

<div class="sumChatHist-summaryCard">
    <h3 class="sumChatHist-summaryTitle"> Most Unknowledge Question</h3>

    <div class="sumChatHist-summaryTableWrapper">
        <table class="sumChatHist-summaryTable">
            <thead>
            <tr>
                <th>No</th>
                <th>Question</th>
                <th>Count</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($listUnknowledgeQst):
                for ($i = 0; $i < count($listUnknowledgeQst); $i++):
                    ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= htmlspecialchars($listUnknowledgeQst[$i]['question']) ?></td>
                        <td><?= $listUnknowledgeQst[$i]['qty'] ?></td>
                    </tr>
                <?php
                endfor;
            endif;
            ?>
            </tbody>
        </table>
    </div>

<!--    <div class="sumChatHist-summaryAction">-->
<!--        <a href="/detail/keywords" class="sumChatHist-detailBtn">Detail</a>-->
<!--    </div>-->
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

