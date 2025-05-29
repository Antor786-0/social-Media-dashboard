function submitProfileForm(event) {
  event.preventDefault(); // Prevent default form submission

  const form = document.getElementById('profileForm');
  const formData = new FormData(form);
  const messageDiv = document.getElementById('message');

  fetch('../controller/edit-profile.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      messageDiv.style.color = 'red';
      messageDiv.textContent = data.error;
    } else if (data.success) {
      messageDiv.style.color = 'green';
      messageDiv.textContent = data.success;

      // Update profile image preview if filename returned
      if (data.filename) {
        const profileImg = document.getElementById('profileImg');
        profileImg.src = '../assets/uploads/' + data.filename + '?t=' + new Date().getTime();
      }
    }
  })
  .catch(error => {
    messageDiv.style.color = 'red';
    messageDiv.textContent = 'An error occurred while uploading.';
  });
}

// Attach event listener on form submit
document.getElementById('profileForm').addEventListener('submit', submitProfileForm);
