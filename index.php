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
        $dataPegawai=mysqli_query($koneksi,"SELECT * FROM pegawai WHERE id_pengguna = $_SESSION[id_pengguna]");
        $pegawai=$dataPegawai->fetch_assoc();
        $pegawaiID = $pegawai['id_pegawai'];

        $dateNow = date('Y-m-d');
        $dataAbsensi=mysqli_query($koneksi,"SELECT * FROM absensi WHERE id_pegawai = '$pegawaiID' AND tanggal = '$dateNow'");
        $absensi=$dataAbsensi->fetch_assoc();
        $countAbsensi = mysqli_num_rows($dataAbsensi);

        $ambilJamMasuk=mysqli_query($koneksi,"SELECT * FROM jam_kerja WHERE id_jam_kerja = 1");
        $jamMasuk=$ambilJamMasuk->fetch_assoc();

        $ambilJamKeluar=mysqli_query($koneksi,"SELECT * FROM jam_kerja WHERE id_jam_kerja = 2");
        $jamKeluar=$ambilJamKeluar->fetch_assoc();

        date_default_timezone_set("Asia/Jakarta");
        $times = date('H:i:s');
        $tanggal = date('Y-m-d');
        // echo $tanggal;
        $masukAwal = strtotime($jamMasuk['awal']);
        $masukAkhir = strtotime($jamMasuk['akhir']);
        $keluarAwal = strtotime($jamKeluar['awal']);
        $keluarAkhir = strtotime($jamKeluar['akhir']);
        $time = strtotime($times);
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
                            <div class="col-sm-4">
                                <?php
                                    if($countAbsensi == 0){
                                        if($time >= $masukAwal){
                                            echo "<form action='' method='post'><button type='submit' name='masuk' class='btn btn-lg btn-success btn-block py-5 px-5'><i class='fas fa-3x fa-sign-in-alt'></i><br>Absen Masuk</button></form>";
                                        }else{
                                            echo "<button type='submit' name='masuk' class='btn btn-lg btn-success btn-block py-5 px-5' disabled><i class='fas fa-3x fa-sign-in-alt'></i><br>Absen Masuk</button>";
                                        }
                                    }else{
                                        if($absensi['keterangan'] == 'Cuti'){
                                            echo "<button class='btn btn-lg btn-success btn-block py-5 px-5' disabled><i class='fas fa-3x fa-sign-in-alt'></i><br>Cuti</button>";
                                        }elseif($absensi['keterangan'] == 'Izin Sakit'){
                                            echo "<button class='btn btn-lg btn-success btn-block py-5 px-5' disabled><i class='fas fa-3x fa-sign-in-alt'></i><br>Izin Sakit</button>";
                                        }else{
                                            echo "<button class='btn btn-lg btn-success btn-block py-5 px-5' disabled><i class='fas fa-3x fa-sign-in-alt'></i><br>Sudah Absen Masuk</button>";
                                        }
                                    }
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                    if($countAbsensi !== 0){
                                        if($absensi['keterangan'] == 'Cuti'){
                                            echo"<button class='btn btn-lg btn-danger btn-block py-5 px-5' disabled><i class='fas fa-3x fa-sign-out-alt'></i><br>Cuti</button>";
                                        }elseif($absensi['keterangan'] == 'Izin Sakit'){
                                            echo"<button class='btn btn-lg btn-danger btn-block py-5 px-5' disabled><i class='fas fa-3x fa-sign-out-alt'></i><br>Izin Sakit</button>";
                                        }else{
                                            if($time >= $keluarAwal){
                                                if($absensi['jam_pulang'] == NULL){
                                                    echo"<form action='' method='post'><button type='submit' name='pulang' class='btn btn-lg btn-danger btn-block py-5 px-5'><i class='fas fa-3x fa-sign-out-alt'></i><br>Absen Pulang</button></form>";
                                                }else{
                                                    echo"<button class='btn btn-lg btn-danger btn-block py-5 px-5' disabled><i class='fas fa-3x fa-sign-out-alt'></i><br>Sudah Absen Pulang</button>";
                                                }
                                            }else{
                                                echo"<button class='btn btn-lg btn-danger btn-block py-5 px-5' disabled><i class='fas fa-3x fa-sign-out-alt'></i><br>Absen Pulang</button>";
                                            }
                                        }
                                    }else{
                                        echo"<button class='btn btn-lg btn-danger btn-block py-5 px-5' disabled><i class='fas fa-3x fa-sign-out-alt'></i><br>Absen Pulang</button>";
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                            if (isset($_POST['masuk'])){
                                if($time >= $masukAwal && $time <= $masukAkhir){
                                    $keterangan = 'Tepat Waktu';
                                }elseif($time >= $masukAkhir){
                                    $keterangan = 'Terlambat';
                                }
                                $query = "INSERT INTO absensi(id_pegawai,tanggal,jam_masuk,keterangan) VALUES ('$pegawaiID','$tanggal','$times','$keterangan')";
                                $tambah = mysqli_query($koneksi, $query);
                                if ($tambah) {
                                    echo "<script>alert('Anda Berhasil Absen Masuk')</script>";
                                    echo "<script>location='absensi_perpegawai.php';</script>"; 
                                }
                                else{
                                    echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                    echo "<script>window.location='index.php'</script>";
                                }
                            }
                            if (isset($_POST['pulang'])){
                                $query = "UPDATE absensi SET jam_pulang = '$times' WHERE id_pegawai = '$pegawaiID' AND tanggal = '$dateNow'";
                                $ubah = mysqli_query($koneksi, $query);
                                if ($ubah) {
                                    echo "<script>alert('Anda Berhasil Absen Pulang')</script>";
                                    echo "<script>location='absensi_perpegawai.php';</script>"; 
                                }
                                else{
                                    echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                    echo "<script>window.location='index.php'</script>";
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
<?php
    }
?>