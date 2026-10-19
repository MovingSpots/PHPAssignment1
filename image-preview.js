'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('image');
    const preview = document.getElementById('image_preview');
    const emptyMessage = document.getElementById('no_image_message');
    const status = document.getElementById('image_preview_status');
    const removeImage = document.getElementById('remove_image');

    if (!input || !preview || !emptyMessage || !status) {
        return;
    }

    const existingSource = preview.dataset.existingSrc || '';
    const maximumBytes = 2 * 1024 * 1024;
    let previewUrl = null;

    const releasePreviewUrl = () => {
        if (previewUrl !== null) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }
    };

    const hidePreview = (message) => {
        preview.hidden = true;
        preview.removeAttribute('src');
        emptyMessage.hidden = false;
        status.textContent = message;
    };

    const showExistingImage = () => {
        releasePreviewUrl();
        if (existingSource !== '') {
            preview.src = existingSource;
            preview.hidden = false;
            emptyMessage.hidden = true;
            status.textContent = 'Current saved image.';
        } else {
            hidePreview('Choose an image to preview it before saving.');
        }
    };

    input.addEventListener('change', () => {
        releasePreviewUrl();
        const file = input.files && input.files[0];

        if (!file) {
            showExistingImage();
            return;
        }
        if (!file.type.startsWith('image/')) {
            input.value = '';
            showExistingImage();
            status.textContent = 'Choose a JPG, PNG, GIF, or WebP image.';
            return;
        }
        if (file.size > maximumBytes) {
            input.value = '';
            showExistingImage();
            status.textContent = 'The image must be 2 MB or smaller.';
            return;
        }

        previewUrl = URL.createObjectURL(file);
        preview.src = previewUrl;
        preview.hidden = false;
        emptyMessage.hidden = true;
        status.textContent = `New image selected: ${file.name}`;
        if (removeImage) {
            removeImage.checked = false;
        }
    });

    if (removeImage) {
        removeImage.addEventListener('change', () => {
            if (removeImage.checked) {
                input.value = '';
                releasePreviewUrl();
                hidePreview('The current image will be removed when you save changes.');
            } else {
                showExistingImage();
            }
        });
    }

    window.addEventListener('beforeunload', releasePreviewUrl);
});
