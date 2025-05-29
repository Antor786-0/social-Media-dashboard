document.addEventListener('DOMContentLoaded', function () {
  // Set username from sessionStorage/localStorage (or fetch from server if needed)
  const email = localStorage.getItem('currentUser');
  if (email) {
    document.getElementById('username').textContent = email.split('@')[0];
  }

  // Toggle schedule options
  document.getElementById('schedulePost').addEventListener('change', function () {
    const options = document.getElementById('scheduleOptions');
    options.style.display = this.checked ? 'block' : 'none';
  });

  // Show message function
  function showMessage(text, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.textContent = text;
    messageDiv.className = 'message ' + type;
  }

  // Handle form submit with AJAX
  document.getElementById('postForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const content = document.getElementById('postContent').value.trim();
    const isScheduled = document.getElementById('schedulePost').checked;
    const postTime = document.getElementById('postTime').value;

    // Client-side validation
    if (!content) {
      showMessage('Please write something to post!', 'error');
      return;
    }
    if (isScheduled && !postTime) {
      showMessage('Please select a time for scheduled post!', 'error');
      return;
    }

    // Prepare form data for POST
    const formData = new URLSearchParams();
    formData.append('postContent', content);
    if (isScheduled) formData.append('schedulePost', 'on');
    formData.append('postTime', postTime);

    fetch('../controller/post.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: formData.toString(),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          showMessage(data.message, 'success');
          // Clear form
          document.getElementById('postContent').value = '';
          document.getElementById('schedulePost').checked = false;
          document.getElementById('scheduleOptions').style.display = 'none';
        } else {
          showMessage(data.message, 'error');
        }
      })
      .catch(() => {
        showMessage('Server error. Please try again.', 'error');
      });
  });
});
