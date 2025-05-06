document.addEventListener('DOMContentLoaded', function() {
    // Set username from localStorage
    const email = localStorage.getItem('currentUser');
    if (email) {
      document.getElementById('username').textContent = email.split('@')[0];
    }
    
    // Handle form submission
    document.getElementById('profileForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const profilePhoto = document.getElementById('profilePhoto').files[0];
      const coverPhoto = document.getElementById('coverPhoto').files[0];
      const theme = document.getElementById('theme').value;
      const featuredPosts = Array.from(document.getElementById('featuredPosts').selectedOptions).map(option => option.value);
      
      // In a real app, you would upload files to a server
      console.log('Profile updated:', { profilePhoto: profilePhoto?.name, coverPhoto: coverPhoto?.name, theme, featuredPosts });
      
      // Show success message
      showMessage('Profile updated successfully!', 'success');
    });
    
    function showMessage(text, type) {
      const messageDiv = document.getElementById('message');
      messageDiv.textContent = text;
      messageDiv.className = 'message ' + type;
    }
  });