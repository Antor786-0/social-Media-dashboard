function submitProfileForm(event) {
  event.preventDefault(); 

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

document.getElementById('profileForm').addEventListener('submit', submitProfileForm);
