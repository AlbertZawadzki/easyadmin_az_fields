const basicCropInputClass = 'ea-az-crop-input';

document.addEventListener("DOMContentLoaded", () => {
    const cropperObserver = new MutationObserver(() => {
        const cropperInputs = document.querySelectorAll(`.${basicCropInputClass}`);
        cropperInputs.forEach(addCropperInputListener);
    });

    cropperObserver.observe(document.body, {
        childList: true,
        subtree: true,
    });

    const initialInputs = document.querySelectorAll(`.${basicCropInputClass}`);
    initialInputs.forEach(addCropperInputListener);
});

const getCropperSettings = (element) => {
    const {
        responsive,
        zoomable,
        scalable,
        aspectRatio,
        viewMode,
        autoCropArea,
        unit,
    } = element.dataset;

    return {
        responsive: responsive === 'true',
        zoomable: zoomable === 'true',
        scalable: scalable === 'true',
        aspectRatio: aspectRatio ? parseFloat(aspectRatio) : unit,
        viewMode: parseInt(viewMode),
        autoCropArea: parseInt(autoCropArea),
        unit,
    };
}

const addCropperInputListener = (input) => {
    if (input.dataset.registered) {
        return;
    }
    input.dataset.registered = true;

    const CropperClass = Cropper.default || Cropper;
    let cropperInstance = null;
    const reader = new FileReader();
    const container = input.closest('.ea-az-crop-field-wrapper');
    const image = container.querySelector(`.ea-az-cropper-preview`);
    const oldImage = container.querySelector(`.${basicCropInputClass}-old-image`);
    const xField = container.querySelector(`.${basicCropInputClass}-x`);
    const yField = container.querySelector(`.${basicCropInputClass}-y`);
    const widthField = container.querySelector(`.${basicCropInputClass}-width`);
    const heightField = container.querySelector(`.${basicCropInputClass}-height`);
    const btnDelete = container.querySelector('.ea-az-btn-delete');
    const btnChange = container.querySelector('.ea-az-btn-change');
    const btnCrop = container.querySelector('.ea-az-btn-crop');
    const cropperSettings = getCropperSettings(container);

    input.addEventListener('change', (event) => {
        btnChange.disabled = true;
        btnCrop.disabled = false;
        btnDelete.disabled = false;
        const file = event.target.files[0];
        reader.readAsDataURL(file);
    });

    reader.onload = () => {
        image.src = reader.result;

        if (cropperInstance) {
            cropperInstance.destroy();
        }

        cropperInstance = new CropperClass(
            image,
            {
                ...cropperSettings,
                crop(event) {
                    xField.value = Math.round(event.detail.x);
                    yField.value = Math.round(event.detail.y);
                    widthField.value = Math.round(event.detail.width);
                    heightField.value = Math.round(event.detail.height);
                },
            }
        );
    };

    btnDelete.addEventListener('click', () => {
        btnDelete.disabled = true;
        btnChange.disabled = false;
        btnCrop.disabled = true;
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }
        oldImage.value = '';
        image.src = '';
        input.value = '';
    });

    btnChange.addEventListener('click', () => {
        input.click();
    });

    btnCrop.addEventListener('click', () => {
        if (!cropperInstance) {
            console.error("cropperInstance not found");
            return;
        }
        const croppedCanvas = cropperInstance.getCroppedCanvas();
        if (!croppedCanvas) {
            console.error("croppedCanvas not found");
            return;
        }

        image.src = croppedCanvas.toDataURL();
        cropperInstance.destroy();
        cropperInstance = null;
        btnChange.disabled = false;
        btnCrop.disabled = true;
        btnDelete.disabled = false;
    });
}
