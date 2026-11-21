import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('avatar');
    const modal = document.getElementById('avatar-crop-modal');
    if (!input || !modal) return;

    const image = document.getElementById('avatar-crop-image');
    const preview = document.getElementById('avatar-preview');
    const fileName = document.getElementById('avatar-file-name');
    const applyBtn = modal.querySelector('[data-crop-apply]');
    const errorBox = document.getElementById('avatar-crop-error');

    let cropper = null;
    let objectUrl = null;
    let originalName = 'avatar';

    const openModal = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        cropper?.destroy();
        cropper = null;
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
        image.removeAttribute('src');
    };

    const cancel = () => {
        input.value = '';
        closeModal();
    };

    input.addEventListener('change', () => {
        const file = input.files?.[0];
        if (!file) return;

        errorBox.textContent = '';

        if (!file.type.startsWith('image/')) {
            input.value = '';
            return;
        }

        originalName = file.name.replace(/\.[^.]+$/, '') || 'avatar';
        objectUrl = URL.createObjectURL(file);
        openModal();

        image.addEventListener(
            'load',
            () => {
                cropper?.destroy();
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.9,
                    background: false,
                    guides: false,
                    center: true,
                    responsive: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            },
            { once: true },
        );
        image.src = objectUrl;
    });

    modal.addEventListener('click', (e) => {
        const action = e.target.closest('[data-crop-action]')?.dataset.cropAction;
        if (!action || !cropper) return;

        if (action === 'zoom-in') cropper.zoom(0.1);
        if (action === 'zoom-out') cropper.zoom(-0.1);
        if (action === 'rotate') cropper.rotate(90);
        if (action === 'reset') cropper.reset();
    });

    modal.querySelectorAll('[data-crop-cancel]').forEach((el) => el.addEventListener('click', cancel));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) cancel();
    });

    applyBtn.addEventListener('click', () => {
        if (!cropper) return;

        applyBtn.disabled = true;

        const canvas = cropper.getCroppedCanvas({
            width: 512,
            height: 512,
            fillColor: '#ffffff',
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        canvas.toBlob(
            (blob) => {
                applyBtn.disabled = false;

                if (!blob) {
                    errorBox.textContent = 'Could not crop the image. Please try again.';
                    return;
                }

                const croppedFile = new File([blob], `${originalName}.jpg`, { type: 'image/jpeg' });

                // Replace the selected file with the cropped one
                const dt = new DataTransfer();
                dt.items.add(croppedFile);
                input.files = dt.files;

                // Update preview and file name
                preview.src = URL.createObjectURL(croppedFile);
                if (fileName) fileName.textContent = croppedFile.name;

                closeModal();
            },
            'image/jpeg',
            0.92,
        );
    });
});