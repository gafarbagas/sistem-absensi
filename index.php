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

    $ambilUserLogin=mysqli_query($koneksi,"SELECT * FROM pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $userLogin=$ambilUserLogin->fetch_assoc();
    if ($userLogin['role'] == 'Admin'){
        $pegawai = mysqli_query($koneksi,"SELECT COUNT(*) as 'count' FROM pegawai");
        $rowPegawai = $pegawai->fetch_assoc();
        $countPegawai = $rowPegawai['count'];

        $jabatan = mysqli_query($koneksi,"SELECT COUNT(*) as 'count' FROM jabatan");
        $rowJabatan = $jabatan->fetch_assoc();
        $countJabatan = $rowJabatan['count'];
    }elseif ($userLogin['role'] == 'Pegawai'){
        date_default_timezone_set("Asia/Jakarta");
        $time = date('H:i:s');
        $tanggal = date('Y-m-d');
        $ambil=mysqli_query($koneksi,"SELECT * FROM pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
        $userLogin=$ambil->fetch_assoc();
        $idPengguna = $userLogin['id_pengguna'];

        $dataPegawai=mysqli_query($koneksi,"SELECT * FROM pegawai WHERE id_pengguna = $_SESSION[id_pengguna]");
        $pegawai=$dataPegawai->fetch_assoc();

        $jamKerjaMasuk=mysqli_query($koneksi,"SELECT * FROM jam_kerja WHERE id_jam_kerja = 1");
        $jamMasuk=$jamKerjaMasuk->fetch_assoc();

        $jamKerjaKeluar=mysqli_query($koneksi,"SELECT * FROM jam_kerja WHERE id_jam_kerja = 2");
        $jamKeluar=$jamKerjaKeluar->fetch_assoc();
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

    <?php
        include ('include/include-style.php');
    ?>
    <title>Beranda</title>

</head>

<body id="page-top">

    <div id="wrapper">

        <?php
            include('include/include-sidebar.php');
        ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php
                    include('include/include-navbar.php');
                ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 text-dark">Beranda</h1>
                    </div>

                    <?php
                        $ambil=mysqli_query($koneksi,"SELECT * FROM pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
                        $userLogin=$ambil->fetch_assoc();
                        if ($userLogin['role'] == 'Admin'){
                    ?>
                            <div class="row">

                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                                        Jabatan</div>
                                                    <div class="h5 mb-0 font-weight-bold text-dark"><?php echo $countJabatan?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-address-card fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-md font-weight-bold text-warning text-uppercase mb-1">
                                                        Pegawai</div>
                                                    <div class="h5 mb-0 font-weight-bold text-dark"><?php echo $countPegawai?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }elseif ($userLogin['role'] == 'Pegawai'){
                    ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <form action="" method="post">
                                    <button type="submit" name="masuk" class="btn btn-lg btn-success btn-block py-5 px-5"><i class="fas fa-3x fa-sign-in-alt"></i><br>Masuk</button>
                                </form>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="pulang" class="btn btn-lg btn-danger btn-block py-5 px-5"><i class="fas fa-3x fa-sign-out-alt"></i><br>Pulang</button>
                            </div>
                        </div>
                    <?php
                            if (isset($_POST['masuk'])){
                                $idPegawai = $pegawai['id_pegawai'];
                                $query = "INSERT INTO absensi(id_pegawai,tanggal,jam_masuk) VALUES ('$idPegawai','$tanggal','$time')";
                                $tambah = mysqli_query($koneksi, $query);
                                if ($tambah) {
                                    echo "<script>alert('Anda Berhasil Absen Masuk')</script>";
                                    echo "<script>location='index.php';</script>"; 
                                }
                                else{
                                    echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                    echo "<script>window.location='index.php'</script>";
                                }
                            }
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

    <?php
        include('include/include-script.php');
    ?>

</body>

</html>