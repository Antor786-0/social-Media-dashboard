function handleDrop(event) {
  event.preventDefault();
    const files = event.dataTransfer.files;
       processFiles(files);
}
          document.getElementById('photoUpload').addEventListener('change', (event) => {
            const files = event.target.files;
              processFiles(files);
});

                   document.querySelector('.upload-area').addEventListener('click', () => {
    document.getElementById('photoUpload').click();
});

                        function processFiles(files) {
                           const albumName = document.getElementById('albumName').value.trim() || 'Untitled Album';

                              Array.from(files).forEach((file) => {
if (!file.type.startsWith('image/')) {
                                 alert(`${file.name} is not an image file.`);
                              return;
        }

                         uploadToServer(file, albumName, (response) => {
if (response.success) {
                      addPhotoToAlbum(albumName, response.filePath, file.name);
    } else {
                alert(response.message || 'Failed to upload image.');
           }
        });
    });
}

        function addPhotoToAlbum(albumName, filePath, altText) {
      let albumContainer = document.getElementById(`album-${albumName}`);

if (!albumContainer) {
        albumContainer = document.createElement('div');
         albumContainer.id = `album-${albumName}`;
          albumContainer.className = 'album';
           albumContainer.innerHTML = `<h3>${albumName}</h3>`;
             document.getElementById('albumList').appendChild(albumContainer);
    }

        const img = document.createElement('img');
             img.src = filePath;
            img.alt = altText;
          img.style.maxWidth = '150px';
         img.style.margin = '5px';
    albumContainer.appendChild(img);
}

    function uploadToServer(file, albumName, callback) {
      const formData = new FormData();
        formData.append('photo', file);
          formData.append('album_name', albumName);

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

         document.getElementById('createAlbum').addEventListener('click', () => {
             const albumNameInput = document.getElementById('albumName');
                 const albumName = albumNameInput.value.trim();
if (!albumName) {
                     alert('Please enter an album name.');
                        return;
    }
                           fetch('../controller/create-album.php', {
                               method: 'POST',
                                 headers: { 'Content-Type': 'application/json' },
                                   body: JSON.stringify({ album_name: albumName })
    })
                                     .then((res) => res.json())
                                       .then((data) => {
if (data.success) {
                let albumList = document.getElementById('albumList');
if (!document.getElementById(`album-${albumName}`)) {
               let albumContainer = document.createElement('div');
                    albumContainer.id = `album-${albumName}`;
                     albumContainer.className = 'album';
                      albumContainer.innerHTML = `<h3>${albumName}</h3>`;
                       albumList.appendChild(albumContainer);
                }
                          albumNameInput.value = '';
    } else {
            alert(data.message || 'Failed to create album.');
           }
        })
            .catch(() => alert('Network error when creating album.'));
});