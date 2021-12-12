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
                        <h1 class="h3 text-dark">Tambah Data Pegawai</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="">
                                        <p><b>Data Diri Pegawai</b></p>
                                        <div class="form-group row">
                                            <label for="nip"  class="col-sm-2 col-form-label">NIP</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="nip" id="nip" placeholder="NIP" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name"  class="col-sm-2 col-form-label">Nama Pegawai</label>
                                            <div class="col-sm">
                                                <input type="text" class="form-control" name="nama_pegawai" id="name" placeholder="Nama Pegawai" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="id_jabatan"  class="col-sm-2 col-form-label">Nama Jabatan</label>
                                            <div class="col-sm-4">
                                                <select type="text" class="form-control" name="id_jabatan" id="id_jabatan" required>
                                                    <option>Pilih Jabatan</option>
                                                    <?php
                                                        $ambil=mysqli_query($koneksi,"SELECT * from jabatan order by id_jabatan DESC");
                                                        while($jabatan=$ambil->fetch_assoc()){
                                                    ?>
                                                    <option value="<?php echo $jabatan['id_jabatan']?>"><?php echo $jabatan['nama_jabatan']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="alamat"  class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm">
                                                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="no_telp"  class="col-sm-2 col-form-label">No. Telp</label>
                                            <div class="col-sm">
                                                <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No. Telp" required>
                                            </div>
                                        </div>

                                        <hr>

                                        <p><b>Data Akun Pegawai</b></p>

                                        <div class="form-group row">
                                            <label for="username"  class="col-sm-2 col-form-label">Username</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password"  class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-7">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
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