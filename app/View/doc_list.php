<div class="docList-page">
    <div class="docList-header">
        <h1 class="docList-title">Documents</h1>
        <a href="/va/upload" class="docList-btnUpload">+ Upload Document</a>
    </div>

    <div class="docList-content">
        <table class="docList-table">
            <thead>
            <tr>
                <th class="docList-colNo">#</th>
                <th class="docList-colDocName">Document Name</th>
                <th>Type</th>
                <th class="docList-colAction" colspan="2">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($model["docList"])): ?>
                <?php foreach ($model["docList"] as $index => $doc): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($doc->getDocName()) ?></td>
                        <td><?= htmlspecialchars(explode('/', $doc->getDocType())[1] ?? $doc->getDocType()) ?></td>
                        <td>
                            <button class="docList-btnDownload" data-doc="<?= htmlspecialchars($doc->getRefDocId()) ?>"> Download </button>
                        </td>
                        <td>
                            <button class="docList-btnDelete" data-doc="<?= htmlspecialchars($doc->getRefDocId()) ?>">
                                Delete
                            </button>
                            <form id="docListDeleteForm" action="/va/knowledge/list" method="post" style="display:none;">
                                <input type="hidden" name="docId" id="docListDeleteId">
                                <input type="hidden" name="actionType" value="delete">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="docList-empty">No documents available.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="docList-footer">
        <form id="docListActivateForm" action="/va/knowledge/list" method="post">
            <input type="hidden" name="actionType" value="activate">
            <button type="button" class="docList-btnActivate" id="docListActivateBtn">
                Activate Documents
            </button>
        </form>
    </div>
</div>

<div class="docList-modal" id="docListActivateModal">
    <div class="docList-modalBox">
        <h2 class="docList-modalTitle">Activate All Documents</h2>
        <p class="docList-modalText">Are you sure you want to activate all documents?</p>
        <div class="docList-modalActions">
            <button class="docList-btnCancel" id="docListActivateCancel">Cancel</button>
            <button class="docList-btnConfirm" id="docListActivateConfirm">Activate</button>
        </div>
    </div>
</div>

<div class="docList-modal" id="docListModal">
    <div class="docList-modalBox">
        <h2 class="docList-modalTitle">Delete Document</h2>
        <p class="docList-modalText">Are you sure you want to delete this document?</p>
        <div class="docList-modalActions">
            <button class="docList-btnCancel" id="docListCancelBtn">Cancel</button>
            <button class="docList-btnConfirm" id="docListConfirmBtn">Delete</button>
        </div>
    </div>
</div>

<div class="docList-modalNotif" id="docListNotif">
    <div class="docList-modalNotifBox">
        <h2 class="docList-modalNotifTitle" id="docListNotifTitle">Notification</h2>
        <p class="docList-modalNotifMessage" id="docListNotifMessage">Message goes here...</p>
        <button class="docList-modalNotifOk" id="docListNotifOk">OK</button>
    </div>
</div>

<script>
    const modal = document.getElementById('docListModal');
    const cancelBtn = document.getElementById('docListCancelBtn');
    const confirmBtn = document.getElementById('docListConfirmBtn');
    const hiddenForm = document.getElementById('docListDeleteForm');
    const hiddenInput = document.getElementById('docListDeleteId');
    let selectedDoc = null;

    document.querySelectorAll('.docList-btnDelete').forEach(btn => {
        btn.addEventListener('click', () => {
            selectedDoc = btn.getAttribute('data-doc');
            modal.classList.add('docList-show');
        });
    });

    cancelBtn.addEventListener('click', () => {
        modal.classList.remove('docList-show');
        selectedDoc = null;
    });

    confirmBtn.addEventListener('click', () => {
        if (selectedDoc) {
            hiddenInput.value = selectedDoc;
            hiddenForm.submit();
        }
    });


    const notifModal = document.getElementById('docListNotif');
    const notifTitle = document.getElementById('docListNotifTitle');
    const notifMessage = document.getElementById('docListNotifMessage');
    const notifOk = document.getElementById('docListNotifOk');

    notifOk.addEventListener('click', () => {
        notifModal.classList.remove('docList-show');
    });

    function showDocListNotification(title, message, type = "info") {
        notifTitle.textContent = title;
        notifMessage.innerHTML = message;

        notifModal.classList.remove('docList-info', 'docList-success', 'docList-error');
        notifModal.classList.add('docList-show', `docList-${type}`);
    }

    document.querySelectorAll('.docList-btnDownload').forEach(btn => {
        btn.addEventListener('click', () => {
            const row = btn.closest('tr');
            const docName = row.querySelector('td:nth-child(2)').textContent.trim();
            const docId = btn.getAttribute('data-doc');

            if (!docId) {
                showDocListNotification("Error", "Document ID not found.", "error");
                return;
            }

            const downloadUrl = `/va/knowledge/download?docId=${encodeURIComponent(docId)}`;
            const link = document.createElement('a');
            link.href = downloadUrl;
            link.download = docName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });

    // ============================
    // Activate All Documents Logic
    // ============================
    const activateBtn = document.getElementById('docListActivateBtn');
    const activateModal = document.getElementById('docListActivateModal');
    const activateCancel = document.getElementById('docListActivateCancel');
    const activateConfirm = document.getElementById('docListActivateConfirm');
    const activateForm = document.getElementById('docListActivateForm');

    activateBtn.addEventListener('click', () => {
        activateModal.classList.add('docList-show');
    });

    activateCancel.addEventListener('click', () => {
        activateModal.classList.remove('docList-show');
    });

    activateConfirm.addEventListener('click', () => {
        activateModal.classList.remove('docList-show');
        activateForm.submit();
    });

</script>

<?php if (!empty($model["notif"])): ?>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            showDocListNotification(
                "Notification",
                "<?= $model["notif"] ?? "Error in application, please contact your administrator."?>",
                "<?= $model["notifType"] ?? "info" ?>"
            );
        });
    </script>
<?php endif; ?>