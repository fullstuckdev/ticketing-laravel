document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.menu-toggle');
    toggles.forEach(toggle => {
      toggle.addEventListener('click', function () {
        const submenu = this.nextElementSibling; // ✅ Tambahkan baris ini
        if (submenu) {
          submenu.classList.toggle('hidden');
          const icon = this.querySelector('.toggle-icon');
          if (icon) {
            icon.classList.toggle('fa-angle-right');
            icon.classList.toggle('fa-angle-down');
          }
        }
      });
    });
    

    const profileToggle = document.getElementById('profile-toggle');
    const profileMenu = document.getElementById('profile-menu');
    const mailboxIcon = document.getElementById('mailbox-icon');
    const emailMenu = document.getElementById('email-menu');
    const bellIcon = document.getElementById('bell-icon');
    const notificationMenu = document.getElementById('notification-menu');

    profileToggle.addEventListener('click', function (event) {
      profileMenu.classList.toggle('hidden');
      emailMenu.classList.add('hidden');
      notificationMenu.classList.add('hidden');
      event.stopPropagation();
    });

    mailboxIcon.addEventListener('click', function (event) {
      emailMenu.classList.toggle('hidden');
      profileMenu.classList.add('hidden');
      notificationMenu.classList.add('hidden');
      event.stopPropagation();
    });

    bellIcon.addEventListener('click', function (event) {
      notificationMenu.classList.toggle('hidden');
      profileMenu.classList.add('hidden');
      emailMenu.classList.add('hidden');
      event.stopPropagation();
    });

    document.addEventListener('click', function () {
      profileMenu.classList.add('hidden');
      emailMenu.classList.add('hidden');
      notificationMenu.classList.add('hidden');
    });

    const minimizeToggle = document.getElementById('minimize-toggle');
    const content = document.getElementById('content');
    minimizeToggle.addEventListener('click', function () {
      content.classList.toggle('hidden');
      this.querySelector('i').classList.toggle('fa-minus');
      this.querySelector('i').classList.toggle('fa-plus');
    });

    const submenuLinks = document.querySelectorAll('.submenu-link');
  submenuLinks.forEach(link => {
  link.addEventListener('click', function (e) {
    e.preventDefault();
    const url = this.getAttribute('data-url');
    

    fetch(url)
      .then(response => response.text())
      .then(html => {
        content.innerHTML = html;
      })
      .catch(error => {
        content.innerHTML = `<p class="text-red-500">Gagal memuat konten.</p>`;
        console.error("Error loading content:", error);
      });
  });
});

// Cek parameter "section" di URL, lalu klik submenu yang sesuai
const urlParams = new URLSearchParams(window.location.search);
const section = urlParams.get('section');
if (section === 'daftar-member') {
  const daftarMemberLink = document.querySelector('[data-url="daftar-member.php"]');
  if (daftarMemberLink) {
    daftarMemberLink.click();
  }
}


  });