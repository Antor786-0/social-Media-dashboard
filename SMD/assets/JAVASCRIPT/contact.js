document.addEventListener('DOMContentLoaded', () => {
  const username = localStorage.getItem('currentUser');
    document.getElementById('username').textContent = username ? username.split('@')[0] : 'Guest';

        const urlParams = new URLSearchParams(window.location.search);
     const flash = urlParams.get('flash');
  const type = urlParams.get('type');

if (flash && type) {
    const div = document.createElement('div');
      div.id = "flashMessage";
        div.className = type;
      div.textContent = decodeURIComponent(flash);
    document.querySelector('.content').appendChild(div);
  }
});