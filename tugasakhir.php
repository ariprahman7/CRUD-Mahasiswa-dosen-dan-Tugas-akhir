<!-- Halaman Head -->
<?php $head = require 'pages/head.php'; 
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['session_username'])) {
    header("Location: login.php");
    exit;
}
?>

    <body class="sb-nav-fixed">
        <!-- Halaman Navbar -->
        <?php $navbar = require 'pages/navbar.php';?>

        <div id="layoutSidenav">
            
            <!-- Halaman Sidebar -->
            <?php
            $sidebar =require 'pages/sidebar.php';
            ?>

            <div id="layoutSidenav_content">
                <!-- Main -->
                <?php $main = require 'pages/content/tugasakhir.php'; ?>

                <!-- Halaman Footer -->
               <?php $footer = require 'pages/footer.php';?>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
