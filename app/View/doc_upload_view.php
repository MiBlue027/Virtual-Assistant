<div class="upload-page-wrapper">
    <?php include __DIR__ . '/head_nav.php'; ?>

    <div class="upload-form-container">
        <h2 class="upload-form-title">Knowledge Upload</h2>

        <form class="upload-form" action="/va/upload" method="post" enctype="multipart/form-data">
            <label class="upload-label">Upload Document (PDF or DOC):</label>
            <input class="upload-input" type="file" name="document" accept=".pdf,.doc,.docx" required>

            <button class="upload-button" type="submit">Upload & Send</button>
            <a href="/va/knowledge/list" class="upload-back-btn">← Back to Knowledge List</a>
        </form>

        <?php if (!empty($model["message"])): ?>
            <div class="upload-message <?= $model["status"] ?? '' ?>">
                <h1><?= htmlspecialchars($model["message"]) ?></h1>
            </div>
        <?php endif; ?>
    </div>
</div>
