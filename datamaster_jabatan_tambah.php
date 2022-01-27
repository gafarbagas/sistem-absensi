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
    if ($userLogin['role'] != 'Admin'){
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
    <title>Tambah Jabatan</title>

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
                        <h1 class="h3 text-dark">Tambah Jabatan</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="">
                                        <div class="form-group row">
                                            <label for="kode_jabatan"  class="col-sm-2 col-form-label">Kode Jabatan</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="kode_jabatan" id="kode_jabatan" placeholder="Kode Bidang" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="nama_jabatan"  class="col-sm-2 col-form-label">Nama Jabatan</label>
                                            <div class="col-sm">
                                                <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" placeholder="Nama Jabatan" required>
                                            </div>
                                        </div>
                                
                                        <div class="text-center">
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
                            $kodeJabatan = $_POST['kode_jabatan'];
                            $namaJabatan = $_POST['nama_jabatan'];
                            $cekJabatan = mysqli_query($koneksi, "SELECT * FROM jabatan WHERE kode_jabatan='$kodeJabatan'");
                            $cek = mysqli_num_rows($cekJabatan);
                            if($cek == 1){
                                echo "<script>alert('Kode Jabatan Tidak Boleh Sama')</script>";
                                echo "<script>window.location='datamaster_jabatan_tambah.php'</script>";
                            }else{
                                $query = "INSERT INTO jabatan(kode_jabatan,nama_jabatan) VALUES ('$kodeJabatan','$namaJabatan')";
                                $tambah = mysqli_query($koneksi, $query);
                                if ($tambah) {
                                    echo "<script>alert('Data berhasil ditambahkan')</script>";
                                    echo "<script>location='datamaster.php';</script>"; 
                                }
                                else{
                                    echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                    echo "<script>window.location='datamaster_jabatan_tambah.php'</script>";
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

<?php
    }
?>