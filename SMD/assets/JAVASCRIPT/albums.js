// albums.js

// Handle drag-and-drop
function handleDrop(event) {
    event.preventDefault();
    const files = event.dataTransfer.files;
    processFiles(files);
}

// Handle click-to-upload
document.getElementById('photoUpload').addEventListener('change', (event) => {
    const files = event.target.files;
    processFiles(files);
});

// Trigger file input click when upload area is clicked
document.querySelector('.upload-area').addEventListener('click', () => {
    document.getElementById('photoUpload').click();
});

// Process uploaded files
function processFiles(files) {
    const albumList = document.getElementById('albumList');
    const albumName = document.getElementById('albumName').value || 'Untitled Album';

    Array.from(files).forEach((file) => {
        if (!file.type.startsWith('image/')) {
            alert(`${file.name} is not an image file.`);
            return;
        }

        uploadToServer(file, albumName, (response) => {
            if (response.success) {
                let albumContainer = document.getElementById(`album-${albumName}`);
                if (!albumContainer) {
                    albumContainer = document.createElement('div');
                    albumContainer.id = `album-${albumName}`;
                    albumContainer.className = 'album';
                    albumContainer.innerHTML = `<h3>${albumName}</h3>`;
                    albumList.appendChild(albumContainer);
                }

                const img = document.createElement('img');
                img.src = response.filePath;
                img.alt = file.name;
                img.style.maxWidth = '150px';
                img.style.margin = '5px';
                albumContainer.appendChild(img);
            } else {
                alert(response.message || 'Failed to upload image.');
            }
        });
    });
}

// Upload file to server
function uploadToServer(file, albumName, callback) {
    const formData = new FormData();
    formData.append('photo', file);
    formData.append('album', albumName);
    formData.append('collaborative', document.getElementById('collaborative').checked);

    fetch('../controller/upload-photo.php', {
        method: 'POST',
        body: formData
    })
        .then((response) => response.json())
        .then((data) => callback(data))
        .catch((error) => {
            console.error('Upload failed:', error);
            callback({ success: false, message: 'Network error during upload.' });
        });
}

// Handle album creation
document.getElementById('createAlbum').addEventListener('click', () => {
    const albumName = document.getElementById('albumName').value.trim();
    if (!albumName) {
        alert('Please enter an album name.');
        return;
    }

    const albumList = document.getElementById('albumList');
    const albumContainer = document.createElement('div');
    albumContainer.id = `album-${albumName}`;
    albumContainer.className = 'album';
    albumContainer.innerHTML = `<h3>${albumName}</h3>`;
    albumList.appendChild(albumContainer);

    document.getElementById('albumName').value = '';
});