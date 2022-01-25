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
    $ambilPegawai=mysqli_query($koneksi, "SELECT * FROM  pegawai WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pegawai=$ambilPegawai->fetch_assoc();
    if ($userLogin['role'] != 'Pegawai'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
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
    <title>Tambah Pegawai</title>

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
                        <h1 class="h3 text-dark">Pengajuan Cuti</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="">
                                        <div class="form-group row">
                                            <label for="jenis_cuti"  class="col-sm-4 col-form-label">Jenis Cuti</label>
                                            <div class="col-sm-8">
                                                <select type="text" class="form-control" name="jenis_cuti" id="jenis_cuti" required>
                                                    <option disabled selected>Pilih Jenis Cuti</option>
                                                    <option value="Cuti Nikah">Cuti Nikah</option>
                                                    <option value="Cuti Hamil&Melahirkan">Cuti Hamil&Melahirkan</option>
                                                    <option value="Lainnya...">Lainnya...</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="awal_cuti"  class="col-sm-4 col-form-label">Tanggal Awal Cuti</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" name="awal_cuti" id="awal_cuti" placeholder="Tanggal Awal Cuti" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="akhir_cuti"  class="col-sm-4 col-form-label">Tanggal Akhir Cuti</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" name="akhir_cuti" id="akhir_cuti" placeholder="Tanggal Akhir Cuti" required>
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
                            $jenis_cuti = $_POST['jenis_cuti'];
                            $awal_cuti = $_POST['awal_cuti'];
                            $akhir_cuti = $_POST['akhir_cuti'];
                            $status = 'Belum Dikonfirmasi';

                            $query = "INSERT INTO cuti (jenis_cuti,awal_cuti,akhir_cuti,status,id_pegawai) VALUES ('$jenis_cuti','$awal_cuti','$akhir_cuti','$status','$id_pegawai')";
                            // die($query);
                            $tambah = mysqli_query($koneksi, $query);
                            if ($tambah) {
                                echo "<script>alert('Data berhasil ditambahkan')</script>";
                                echo "<script>location='cuti.php';</script>";
                            }
                            else{
                                echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                echo "<script>window.location='cuti_pengajuan.php'</script>";
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