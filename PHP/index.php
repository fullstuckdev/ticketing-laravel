<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit();
}

// Session timeout (misal, logout setelah 30 detik)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    session_unset(); 
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();
?>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include 'title.php'; ?>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="style.css" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Tambahkan pop-up Selamat Datang -->
      <?php 
    if (isset($_SESSION['user_username']) && !isset($_SESSION['welcome_shown'])) {
      $_SESSION['welcome_shown'] = true;
    ?>
      <script>
        window.onload = function() {
          alert("Selamat datang, <?php echo $_SESSION['user_username']; ?>!");
        }
      </script>
    <?php } ?>
<body class="bg-gray-100">
  <div class="flex h-screen">

    <!-- Sidebar -->
    <div class="bg-gray-800 text-white w-64 flex flex-col">
      <div class="flex items-center justify-center h-16 bg-blue-700">
      <img src="images/removemtau.png" alt="Logo" class="h-10 w-10 mr-2"> <!-- Tambahkan logo -->
        <h1 class="text-xl font-bold">MTAU HELPDESK</h1>
      </div>
      <div class="flex items-center p-4">
        <img alt="User profile picture of Aditya Yuda" class="rounded-full" height="40" src="" width="40"/>
        <div class="ml-4">
          <p>Aditya Yuda</p>
          <p class="text-green-500 text-sm">● online</p>
        </div>
      </div>
      <nav class="flex-1 px-2 py-4 space-y-1">
        <!-- <p class="text-gray-400 px-2 text-center bg-gray-700 py-2 rounded-md">MAIN NAVIGATION</p> -->
        <div>
          <a class="flex items-center justify-between px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 menu-toggle" href="#">
            <div class="flex items-center">
              <i class="fas fa-tachometer-alt mr-3"></i>
              Dashboard
            </div>
            <i class="fas fa-angle-right toggle-icon"></i>
          </a>
          <div class="ml-6 hidden">
            <a class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 submenu-link" href="#">
              <i class="fas fa-angle-right mr-3"></i>
              Semua Kategori
            </a>
          </div>
        </div>
        <div>
          <a class="flex items-center justify-between px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 menu-toggle" href="#">
            <div class="flex items-center">
              <i class="fas fa-ticket-alt mr-3"></i>
              Ticket
            </div>
            <i class="fas fa-angle-right toggle-icon"></i>
          </a>
          <div class="ml-6 hidden">
            <a class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 submenu-link" href="#">
              <i class="fas fa-angle-right mr-3"></i>
              Daftar Kategori
            </a>
            <a class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 submenu-link" 
              href="?page=list_ticket">
              <i class="fas fa-angle-right mr-3"></i>
              Daftar Tiket
            </a>
          </div>
        </div>
        <div>
          <a class="flex items-center justify-between px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 menu-toggle" href="#">
            <div class="flex items-center">
              <i class="fas fa-chart-line mr-3"></i>
              Laporan
            </div>
            <i class="fas fa-angle-right toggle-icon"></i>
          </a>
          <div class="ml-6 hidden">
          <a class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 submenu-link" href="?page=laporan_transaksi">
          <i class="fas fa-angle-right mr-3"></i>
          Laporan Transaksi
        </a>
        
          </div>
        </div>
        <div>
          <a class="flex items-center justify-between px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 menu-toggle" href="#">
            <div class="flex items-center">
              <i class="fas fa-user mr-3"></i>
              User
            </div>
            <i class="fas fa-angle-right toggle-icon"></i>
          </a>
          <div class="ml-6 hidden">
          <a class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 submenu-link" 
            href="?page=get_users" data-url="daftar-member.php">
            <i class="fas fa-angle-right mr-3"></i>
            Daftar Member
          </a>
          </div>
        </div>
      </nav>
      <div class="text-center text-gray-400 text-xs p-4">
        <p>Copyright © 2023 MTAU. All Right Reserved</p>
        <p>Ver. 2.3.3</p>
      </div>
    </div>
    <!-- Main content -->
    <div class="flex-1 flex flex-col">
      <header class="flex items-center justify-end h-16 bg-blue-700 text-white px-4">
        <div class="relative">
          <div class="flex items-center space-x-4 cursor-pointer" id="profile-toggle">
            <i class="fas fa-inbox" id="mailbox-icon"></i>
            <i class="fas fa-bell" id="bell-icon"></i>
            <div class="flex items-center">
              <img alt="User profile picture of Aditya Yuda" class="rounded-full" height="40" src="" width="40"/>
              <span class="ml-2">Aditya Yuda</span>
            </div>
          </div>
          <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden" id="profile-menu">
            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Profile</a>
            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')">Logout</a>

          </div>
          <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden" id="email-menu">
            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Email 1: Subject 1</a>
            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Email 2: Subject 2</a>
            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Email 3: Subject 3</a>
          </div>
          <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden" id="notification-menu">
            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">New Ticket: Ticket #1234</a>
            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">New Member: Member #5678</a>
          </div>
        </div>
      </header>
      <main class="flex-1 p-6 overflow-auto">
  <?php
  if (isset($_GET['page'])) {
      $page = $_GET['page'];
      $allowed_pages = ['get_users', 'edit_member', 'list_ticket', 'laporan_transaksi']; // Tambahkan page lainnya di sini
      if (in_array($page, $allowed_pages) && file_exists("$page.php")) {
          include "$page.php";
      } else {
          echo "<p class='text-red-500'>Halaman tidak ditemukan.</p>";
      }
  } else {
      echo "<p class='text-gray-700'>Selamat datang di Dashboard!</p>";
  }
  ?>
</main>
    </div>
  </div>
    <script src="script.js"></script>
    <!-- Modal Tambah Member -->
<div id="modalTambah" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 hidden">
  <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
    <!-- Tombol close -->
    <button onclick="document.getElementById('modalTambah').classList.add('hidden')" 
      class="absolute top-2 right-2 text-gray-500 hover:text-red-500">&times;</button>
    
    <?php include 'tambah_member.php'; ?>
  </div>
</div>


</body>
</html>

