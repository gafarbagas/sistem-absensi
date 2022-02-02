<?php 
    session_start();
    $koneksi = mysqli_connect("localhost","root","","db_absensi");
    include "tgl-indo.php";
    if (!isset($_SESSION['id_pengguna'])) 
    {
        echo "<script>alert('Anda harus login');</script>";
        echo "<script>location='login.php';</script>";
        exit();
    }

    $ambilUserLogin=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $userLogin=$ambilUserLogin->fetch_assoc();
    if ($userLogin['role'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
        $ambilIzin=mysqli_query($koneksi,"SELECT * FROM izin WHERE id_izin='$_GET[id]'");
        $izin=$ambilIzin->fetch_assoc();
        $ambilPegawai=mysqli_query($koneksi,"SELECT * FROM pegawai WHERE id_pegawai='$izin[id_pegawai]'");
        $pegawai=$ambilPegawai->fetch_assoc();
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
    <title>Konfirmasi Izin</title>

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
                        <h1 class="h3 text-dark">Konfirmasi Izin</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            Nama Pegawai
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo $pegawai['nama_pegawai'] ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            NIP
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo $pegawai['nip'] ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            Tanggal Awal Izin
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo tgl_indonesia($izin['awal_izin']) ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            Tanggal Akhir Izin
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo tgl_indonesia($izin['akhir_izin']) ?>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            Keterangan Izin
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo $izin['keterangan_izin'] ?>
                                        </div>
                                    </div>

                                    <?php
                                        if($izin['status_izin'] == 'Belum Dikonfirmasi'){
                                    ?>
                                        <form method="post">
                                            <div class="text-center mt-4">
                                                <button class="btn btn-success btn-icon-split btn-sm" name="disetujui">
                                                    <span class="icon">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Disetujui</span>
                                                </button>
                                                <button class="btn btn-danger btn-icon-split btn-sm" name="ditolak">
                                                    <span class="icon">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="text">Ditolak</span>
                                                </button>
                                            </div>
                                        </form>
                                    <?php
                                        }else{
                                    ?>
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                Status Izin
                                            </div>
                                            <div class="col-sm-6">
                                                <?php echo $izin['status_izin'] ?>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        if (isset($_POST['disetujui']))
                        {
                            $status = 'Disetujui';
                            $awalIzin = $izin['awal_izin'];
                            $akhirIzin = $izin['akhir_izin'];
                            $keterangan = 'Izin';
                            $idPegawai = $pegawai['id_pegawai'];
                            
                            $stmt = $koneksi->prepare('INSERT INTO `absensi` (`id_pegawai`, `tanggal`, `keterangan`) VALUES (?, ?, ?)');

                            $awal = DateTime::createFromFormat('Y-m-d', $awalIzin);
                            $akhir = DateTime::createFromFormat('Y-m-d', $akhirIzin);
                            $akhir = $akhir->modify( '+1 day' );
                            $interval = new DateInterval('P1D');
                            $daterange = new DatePeriod($awal, $interval ,$akhir);
                            foreach($daterange as $dr) {
                                $tanggal = $dr->format('Y-m-d');
                                $stmt->bind_param('sss', $idPegawai, $tanggal,$keterangan);
                                $stmt->execute();
                            }

                            $query = "UPDATE izin SET status_izin='$status' WHERE id_izin='$_GET[id]'";
                            $tambah = mysqli_query($koneksi, $query);
                            if ($tambah) {
                                echo "<script>alert('Izin Telah Dikonfirmasi')</script>";
                                echo "<script>location='izin.php';</script>";
                            }
                            else{
                                echo "<script>alert('Anda gagal mengkonfirmasi izin, silahkan ulangi')</script>";
                                echo "<script>window.location='izin_konfirmasi.php?id=$_GET[id]'</script>";
                            }
                        }
                        
                        if(isset($_POST['ditolak'])){
                            $status = 'Ditolak';
                            $awalIzin = $_POST['awal_izin'];
                            $akhirIzin = $_POST['akhir_izin'];
                            $keterangan = 'Izin';
                            $idPegawai = $pegawai['id_pegawai'];
                            $query = "UPDATE izin SET status_izin='$status' WHERE id_izin='$_GET[id]'";
                            $tambah = mysqli_query($koneksi, $query);
                            if ($tambah) {
                                echo "<script>alert('Izin Telah Dikonfirmasi')</script>";
                                echo "<script>location='izin.php';</script>";
                            }
                            else{
                                echo "<script>alert('Anda gagal mengkonfirmasi izin, silahkan ulangi')</script>";
                                echo "<script>window.location='izin_konfirmasi.php?id=$_GET[id]'</script>";
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