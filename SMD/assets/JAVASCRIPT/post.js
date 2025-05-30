document.addEventListener('DOMContentLoaded', function () {
       const email = localStorage.getItem('currentUser');
if (email) {
              document.getElementById('username').textContent = email.split('@')[0];
             }
  document.getElementById('schedulePost').addEventListener('change', function () {
    const options = document.getElementById('scheduleOptions');
    options.style.display = this.checked ? 'block' : 'none';
  });
  function showMessage(text, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.textContent = text;
    messageDiv.className = 'message ' + type;
  }

  document.getElementById('postForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const content = document.getElementById('postContent').value.trim();
    const isScheduled = document.getElementById('schedulePost').checked;
    const postTime = document.getElementById('postTime').value;
if (!content) {
      showMessage('Please write something to post!', 'error');
      return;
    }
    if (isScheduled && !postTime) {
      showMessage('Please select a time for scheduled post!', 'error');
      return;
    }
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