<?php 
    session_start();
    $koneksi = mysqli_connect("localhost","root","","db_absensi");
    // include 'tgl-indo.php';
    if (!isset($_SESSION['id_pengguna'])) 
    {
        echo "<script>alert('Anda harus login');</script>";
        echo "<script>location='login.php';</script>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template-->
    <?php
        include ('include/include-style.php');
    ?>
    <title>
        <?php
            if (isset($_GET['halaman'])) 
            {
                if ($_GET['halaman']=="jamkerja") 
                {
                    echo 'Jam Kerja';
                }
                elseif ($_GET['halaman']=="jamkerja-ubah") 
                {
                    echo 'Ubah Jam Kerja';
                }
                elseif ($_GET['halaman']=="jabatan") 
                {
                    echo 'Jabatan';
                }
                elseif ($_GET['halaman']=="jabatan-tambah") 
                {
                    echo 'Tambah Jabatan';
                }
                elseif ($_GET['halaman']=="jabatan-ubah") 
                {
                    echo 'Ubah Jabatan';
                }
                elseif ($_GET['halaman']=="bidang") 
                {
                    echo 'Bidang';
                }
                elseif ($_GET['halaman']=="bidang-tambah") 
                {
                    echo 'Tambah Bidang';
                }
                elseif ($_GET['halaman']=="bidang-ubah") 
                {
                    echo 'Ubah Bidang';
                }
                elseif ($_GET['halaman']=="pengguna") 
                {
                    echo 'Pengguna';
                }
                elseif ($_GET['halaman']=="pengguna-tambah") 
                {
                    echo 'Tambah Pengguna';
                }
                elseif ($_GET['halaman']=="pengguna-ubah") 
                {
                    echo 'Ubah Pengguna';
                }
                elseif ($_GET['halaman']=="pegawai") 
                {
                    echo 'Pegawai';
                }
                elseif ($_GET['halaman']=="pegawai-tambah") 
                {
                    echo 'Tambah Pegawai';
                }
                elseif ($_GET['halaman']=="pegawai-ubah") 
                {
                    echo 'Ubah Pegawai';
                }
                elseif ($_GET['halaman']=="absensi") 
                {
                    echo 'Absensi';
                }
                elseif ($_GET['halaman']=="absensi-ubah") 
                {
                    echo 'Ubah Absensi';
                }
                elseif ($_GET['halaman']=="absensi-pegawai") 
                {
                    echo 'Absensi Pegawai';
                }
                elseif ($_GET['halaman']=="pengguna-ubah-kata-sandi") 
                {
                    echo 'Ubah Kata Sandi Pengguna';
                }
                elseif ($_GET['halaman']=="laporan") 
                {
                    echo 'Laporan';
                }
                elseif ($_GET['halaman']=="profil") 
                {
                    echo 'Profil';
                }
                elseif ($_GET['halaman']=="profilubah") 
                {
                    echo 'Ubah Profil';
                }
            }
            else{
                echo 'Beranda';
            }
        ?>
    </title>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include('include/include-sidebar.php');
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include('include/include-navbar.php');
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <?php
                        if (isset($_GET['halaman'])) 
                        {
                            if ($_GET['halaman']=="jamkerja") 
                            {
                                include 'pages/jamkerja/jamkerja.php';
                            }
                            elseif ($_GET['halaman']=="jamkerja-ubah") 
                            {
                                include 'pages/jamkerja/jamkerja_ubah.php'; 
                            }
                            elseif ($_GET['halaman']=="jabatan") 
                            {
                                include 'pages/jabatan/jabatan.php';
                            }
                            elseif ($_GET['halaman']=="jabatan-tambah") 
                            {
                                include 'pages/jabatan/jabatan_tambah.php'; 
                            }
                            elseif ($_GET['halaman']=="jabatan-ubah") 
                            {
                                include 'pages/jabatan/jabatan_ubah.php'; 
                            }
                            elseif ($_GET['halaman']=="jabatan-hapus") 
                            {
                                include 'pages/jabatan/jabatan_hapus.php'; 
                            }
                            elseif ($_GET['halaman']=="bidang") 
                            {
                                include 'pages/bidang/bidang.php';
                            }
                            elseif ($_GET['halaman']=="bidang-tambah") 
                            {
                                include 'pages/bidang/bidang_tambah.php'; 
                            }
                            elseif ($_GET['halaman']=="bidang-ubah") 
                            {
                                include 'pages/bidang/bidang_ubah.php'; 
                            }
                            elseif ($_GET['halaman']=="bidang-hapus") 
                            {
                                include 'pages/bidang/bidang_hapus.php'; 
                            }
                            elseif ($_GET['halaman']=="pengguna") 
                            {
                                include 'pages/pengguna/pengguna.php';
                            }
                            elseif ($_GET['halaman']=="pengguna-tambah") 
                            {
                                include 'pages/pengguna/pengguna_tambah.php'; 
                            }
                            elseif ($_GET['halaman']=="pengguna-ubah") 
                            {
                                include 'pages/pengguna/pengguna_ubah.php'; 
                            }
                            elseif ($_GET['halaman']=="pengguna-ubah-kata-sandi") 
                            {
                                include 'pages/pengguna/pengguna_ubahkatasandi.php'; 
                            }
                            elseif ($_GET['halaman']=="pengguna-hapus") 
                            {
                                include 'pages/pengguna/pengguna_hapus.php'; 
                            }
                            elseif ($_GET['halaman']=="pegawai") 
                            {
                                include 'pages/pegawai/pegawai.php';
                            }
                            elseif ($_GET['halaman']=="pegawai-tambah") 
                            {
                                include 'pages/pegawai/pegawai_tambah.php'; 
                            }
                            elseif ($_GET['halaman']=="pegawai-ubah") 
                            {
                                include 'pages/pegawai/pegawai_ubah.php'; 
                            }
                            elseif ($_GET['halaman']=="pegawai-ubah-kata-sandi") 
                            {
                                include 'pages/pegawai/pegawai_ubahkatasandi.php'; 
                            }
                            elseif ($_GET['halaman']=="pegawai-hapus") 
                            {
                                include 'pages/pegawai/pegawai_hapus.php'; 
                            }
                            elseif ($_GET['halaman']=="absensi") 
                            {
                                include 'pages/absensi/absensi.php';
                            }
                            elseif ($_GET['halaman']=="absensi-ubah") 
                            {
                                include 'pages/absensi/absensi_ubah.php'; 
                            }
                            elseif ($_GET['halaman']=="absensi-hapus") 
                            {
                                include 'pages/absensi/absensi_hapus.php'; 
                            }
                            elseif ($_GET['halaman']=="absensi-pegawai") 
                            {
                                include 'pages/absensi/absensi_pegawai.php'; 
                            }
                            elseif ($_GET['halaman']=="laporan") 
                            {
                                include 'laporan.php';
                            }
                            elseif ($_GET['halaman']=="profil") 
                            {
                                include 'profil.php';
                            }
                            elseif ($_GET['halaman']=="profilubah") 
                            {
                                include 'profil_ubah.php';
                            }
                            elseif ($_GET['halaman']=="ubahkatasandi") 
                            {
                                include 'profil_ubahkatasandi.php'; 
                            }
                            elseif ($_GET['halaman']=="logout")
                            {
                                include 'logout.php';
                            }
                        }
                        else{
                            include 'pages/home.php';
                        }
                    ?>
                </div>

            </div>

            <?php
                include('include/include-footer.php')
            ?>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin untuk keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Tekan tombol keluar apabila ingin keluar dari sistem.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="index.php?halaman=logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php
        include('include/include-script.php');
    ?>

</body>

</html>