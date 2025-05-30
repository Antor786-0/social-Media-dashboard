document.getElementById('resendForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const messageDiv = document.getElementById('message');

    fetch(form.action, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())  
    .then(data => {
    
        messageDiv.textContent = "Verification email resent! Please check your inbox.";
        messageDiv.style.color = 'green';
    })
    .catch(() => {
        messageDiv.textContent = "Failed to resend email. Please try again.";
        messageDiv.style.color = 'red';
    });
});
