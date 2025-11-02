<div class="upload-form-container">
    <h2 class="upload-form-title">Knowledge Upload</h2>

    <form class="upload-form" action="/va/upload" method="post" enctype="multipart/form-data">
        <label class="upload-label">Upload (Pdf or Doc):</label><br>
        <input class="upload-input" type="file" name="document" accept=".pdf,.doc,.docx" required>
        <br><br>
        <button class="upload-button" type="submit">Upload</button>
    </form>

    <div class="upload-message <?= $model['status'] ?? '' ?>">
        <h1><?= $model["message"] ?? "" ?></h1>
    </div>
</div>
