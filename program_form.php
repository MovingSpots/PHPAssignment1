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

    <?php if (!empty($currentImage)): ?>
        <div class="current-image">
            <span>Current image</span>
            <img src="uploads/<?= escapeHtml($currentImage) ?>" alt="Current program image">
            <label class="checkbox-label"><input type="checkbox" name="remove_image" value="1"> Remove current image</label>
        </div>
    <?php endif; ?>

    <label for="image">Program image <span class="optional">(optional; JPG, PNG, GIF or WebP, maximum 2 MB)</span></label>
    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/gif,image/webp">
    <div class="actions">
        <button class="button" type="submit"><?= escapeHtml($submitLabel) ?></button>
        <a class="button button-secondary" href="index.php">Cancel</a>
    </div>
</form>
