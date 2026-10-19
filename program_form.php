<?php if ($errors !== []): ?>
    <section class="errors" role="alert" aria-labelledby="error-heading">
        <h2 id="error-heading">Please correct the following:</h2>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= escapeHtml($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>

<form class="program-form" action="<?= escapeHtml($formAction) ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= escapeHtml(csrfToken()) ?>">

    <label for="program_name">Program name</label>
    <input id="program_name" name="program_name" type="text" maxlength="100" required value="<?= escapeHtml((string) ($program['program_name'] ?? '')) ?>">

    <label for="category_id">Category</label>
    <select id="category_id" name="category_id" required>
        <option value="">Choose a category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= (int) $category['category_id'] ?>" <?= (int) ($program['category_id'] ?? 0) === (int) $category['category_id'] ? 'selected' : '' ?>><?= escapeHtml($category['category_name']) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="location">Location</label>
    <input id="location" name="location" type="text" maxlength="120" required value="<?= escapeHtml((string) ($program['location'] ?? '')) ?>">

    <label for="schedule">Schedule</label>
    <input id="schedule" name="schedule" type="text" maxlength="100" required placeholder="Example: Saturdays, 10:00 AM" value="<?= escapeHtml((string) ($program['schedule'] ?? '')) ?>">

    <label for="contact_email">Contact email</label>
    <input id="contact_email" name="contact_email" type="email" maxlength="160" required value="<?= escapeHtml((string) ($program['contact_email'] ?? '')) ?>">

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="5" required><?= escapeHtml((string) ($program['description'] ?? '')) ?></textarea>

    <label for="image">Program image <span class="optional">(optional; JPG, PNG, GIF or WebP, maximum 2 MB)</span></label>
    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/gif,image/webp">

    <section class="image-preview-panel" aria-labelledby="preview-heading">
        <h2 id="preview-heading">Image preview</h2>
        <?php $existingImageSource = !empty($currentImage) ? 'uploads/' . escapeHtml($currentImage) : ''; ?>
        <img id="image_preview"
             class="image-preview"
             src="<?= $existingImageSource ?>"
             data-existing-src="<?= $existingImageSource ?>"
             alt="Preview of the selected program image"
             <?= $existingImageSource === '' ? 'hidden' : '' ?>>
        <p id="no_image_message" class="preview-empty" <?= $existingImageSource !== '' ? 'hidden' : '' ?>>No image selected.</p>
        <p id="image_preview_status" class="preview-status" aria-live="polite">
            <?= $existingImageSource !== '' ? 'Current saved image.' : 'Choose an image to preview it before saving.' ?>
        </p>

        <?php if (!empty($currentImage)): ?>
            <label class="checkbox-label">
                <input id="remove_image" type="checkbox" name="remove_image" value="1">
                Remove the current image when changes are saved
            </label>
        <?php endif; ?>
    </section>

    <div class="actions">
        <button class="button" type="submit"><?= escapeHtml($submitLabel) ?></button>
        <a class="button button-secondary" href="index.php">Cancel</a>
    </div>
</form>
<script src="image-preview.js" defer></script>
