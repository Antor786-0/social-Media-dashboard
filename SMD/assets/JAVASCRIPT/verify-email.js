document.getElementById('resendForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const messageDiv = document.getElementById('message');

    fetch(form.action, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())  // or json if your PHP returns json
    .then(data => {
        // In this example, PHP redirects, so not much to do here
        // Instead, you can reload page or show message from session
        messageDiv.textContent = "Verification email resent! Please check your inbox.";
        messageDiv.style.color = 'green';
    })
    .catch(() => {
        messageDiv.textContent = "Failed to resend email. Please try again.";
        messageDiv.style.color = 'red';
    });
});
