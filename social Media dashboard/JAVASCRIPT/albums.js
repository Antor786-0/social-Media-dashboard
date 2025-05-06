document.addEventListener('DOMContentLoaded', function() {
  // Set username from localStorage
  const email = localStorage.getItem('currentUser');
  if (email) {
    document.getElementById('username').textContent = email.split('@')[0];
  }
  
  // Handle album creation
  document.getElementById('createAlbum').addEventListener('click', function() {
    const albumName = document.getElementById('albumName').value;
    const isCollaborative = document.getElementById('collaborative').checked;
    
    if (!albumName) {
      alert('Please enter an album name');
      return;
    }
    
    // In a real app, you would send this to a server
    console.log('Album created:', { albumName, isCollaborative });
    
    // Add to album list (demo)
    const albumList = document.getElementById('albumList');
    const albumDiv = document.createElement('div');
    albumDiv.className = 'album';
    albumDiv.textContent = `${albumName} ${isCollaborative ? '(Collaborative)' : ''}`;
    albumList.appendChild(albumDiv);
    
    // Clear input
    document.getElementById('albumName').value = '';
  });
  
  // Handle file upload click
  document.querySelector('.upload-area').addEventListener('click', function() {
    document.getElementById('photoUpload').click();
  });
  
  // Handle file upload
  document.getElementById('photoUpload').addEventListener('change', function(e) {
    const files = e.target.files;
    console.log('Photos uploaded:', Array.from(files).map(f => f.name));
  });
});

// Handle drag and drop
function handleDrop(e) {
  e.preventDefault();
  const files = e.dataTransfer.files;
  console.log('Photos dropped:', Array.from(files).map(f => f.name));
}