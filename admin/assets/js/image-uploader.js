const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('file-input');
    const uploadButton = document.getElementById('upload-button');
    const preview = document.getElementById('preview');
    const modal = document.getElementById('image-modal');
    const modalImage = document.getElementById('modal-image');
    const closeModal = document.getElementById('close-modal');

    uploadArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        uploadArea.classList.add('dragging');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragging');
    });

    uploadArea.addEventListener('drop', (event) => {
        event.preventDefault();
        uploadArea.classList.remove('dragging');
        const files = event.dataTransfer.files;
        handleFiles(files);
    });

    uploadButton.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent form submission
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        const files = fileInput.files;
        handleFiles(files);
    });

    closeModal.addEventListener('click', () => {
        modal.style.display = "none";
    });

    function handleFiles(files) {
        for (const file of files) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const container = document.createElement('div');
                    container.classList.add('preview-image-container');

                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.classList.add('preview-image');

                    const zoomButton = document.createElement('button');
                    zoomButton.innerText = 'Zoom';
                    zoomButton.classList.add('zoom-button');
                    zoomButton.addEventListener('click', (event) => {
                        event.preventDefault(); // Prevent form submission
                        modalImage.src = img.src;
                        modal.style.display = "block";
                    });

                    container.appendChild(img);
                    container.appendChild(zoomButton);
                    preview.appendChild(container);
                };
                reader.readAsDataURL(file);
            }
        }
    }

    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });