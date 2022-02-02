<?php 
    session_start();
    $koneksi = mysqli_connect("localhost","root","","db_absensi");
    
    if (!isset($_SESSION['id_pengguna'])) 
    {
        echo "<script>alert('Anda harus login');</script>";
        echo "<script>location='login.php';</script>";
        exit();
    }

    $ambilUserLogin=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $userLogin=$ambilUserLogin->fetch_assoc();
    if ($userLogin['role'] != 'Pegawai'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
        $ambilPegawai=mysqli_query($koneksi, "SELECT * FROM  pegawai WHERE id_pengguna = $_SESSION[id_pengguna]");
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
    <title>Pengajuan Izin</title>

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
                        <h1 class="h3 text-dark">Pengajuan Izin</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="" enctype="multipart/form-data">

                                        <div class="form-group row">
                                            <label for="awal_izin"  class="col-sm-3 col-form-label">Tanggal Awal Izin</label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control" name="awal_izin" id="awal_izin" placeholder="Tanggal Awal Izin" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="akhir_izin"  class="col-sm-3 col-form-label">Tanggal Akhir Izin</label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control" name="akhir_izin" id="akhir_izin" placeholder="Tanggal Akhir Izin" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="keterangan_izin"  class="col-sm-3 col-form-label">Ketarangan Izin</label>
                                            <div class="col-sm">
                                                <input type="text" class="form-control" name="keterangan_izin" id="keterangan_izin" placeholder="Ketarangan Izin" required>
                                            </div>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button class="btn btn-primary" name="tambah">
                                                Tambah
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        if (isset($_POST['tambah']))
                        {
                            $id_pegawai = $pegawai['id_pegawai'];
                            $awal_izin = $_POST['awal_izin'];
                            $akhir_izin = $_POST['akhir_izin'];
                            $keterangan_izin = $_POST['keterangan_izin'];
                            $status_izin = 'Belum Dikonfirmasi';

                            $query = "INSERT INTO izin (awal_izin,akhir_izin,keterangan_izin,status_izin,id_pegawai) VALUES ('$awal_izin','$akhir_izin','$keterangan_izin','$status_izin','$id_pegawai')";
                            // die($query);
                            $tambah = mysqli_query($koneksi, $query);
                            if ($tambah) {
                                echo "<script>alert('Data berhasil ditambahkan')</script>";
                                echo "<script>location='izin.php';</script>";
                            }
                            else{
                                echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                echo "<script>window.location='izin_pengajuan.php'</script>";
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