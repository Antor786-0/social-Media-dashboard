// JAVASCRIPT/post.js
document.addEventListener('DOMContentLoaded', function() {
    // Set username from localStorage
    const email = localStorage.getItem('currentUser');
    if (email) {
      document.getElementById('username').textContent = email.split('@')[0];
    }
    
    // Toggle schedule options
    document.getElementById('schedulePost').addEventListener('change', function() {
      const options = document.getElementById('scheduleOptions');
      options.style.display = this.checked ? 'block' : 'none';
    });
    
    // Handle form submission
    document.getElementById('postForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const content = document.getElementById('postContent').value;
      const isScheduled = document.getElementById('schedulePost').checked;
      const postTime = document.getElementById('postTime').value;
      
      // Simple validation
      if (!content) {
        showMessage('Please write something to post!', 'error');
        return;
      }
      
      if (isScheduled && !postTime) {
        showMessage('Please select a time for scheduled post!', 'error');
        return;
      }
      
      // In a real app, you would send this to a server
      console.log('Post created:', { content, isScheduled, postTime });
      
      // Show success message
      showMessage('Post created successfully!', 'success');
      
      // Clear form
      document.getElementById('postContent').value = '';
      document.getElementById('schedulePost').checked = false;
      document.getElementById('scheduleOptions').style.display = 'none';
      
      // In a real app, you might redirect or update the feed
    });
    
    function showMessage(text, type) {
      const messageDiv = document.getElementById('message');
      messageDiv.textContent = text;
      messageDiv.className = 'message ' + type;
    }
  });