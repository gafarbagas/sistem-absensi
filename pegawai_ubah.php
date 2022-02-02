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
        $ambilPegawai=mysqli_query($koneksi,"SELECT * FROM pegawai WHERE id_pegawai='$_GET[id]'");
        $pegawai=$ambilPegawai->fetch_assoc();
        $idPengguna=$pegawai['id_pengguna'];
        $ambilPenggunaPegawai=mysqli_query($koneksi,"SELECT * FROM pengguna WHERE id_pengguna='$idPengguna'");
        $penggunaPegawai=$ambilPenggunaPegawai->fetch_assoc();
        include('pegawai_function.php');
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
    <title>Ubah Pegawai</title>

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
                        <h1 class="h3 text-dark">Ubah Pegawai</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <p><b>Data Diri Pegawai</b></p>
                                        <div class="form-group row">
                                            <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="nip" id="nip" placeholder="NIP" value="<?php echo $pegawai['nip']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="nama_pegawai" class="col-sm-2 col-form-label">Nama Pegawai</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" placeholder="Nama Pegawai" value="<?php echo $pegawai['nama_pegawai']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="id_jabatan"  class="col-sm-2 col-form-label">Jabatan</label>
                                            <div class="col-sm-4">
                                                <select type="text" class="form-control" name="id_jabatan" id="id_jabatan" required>
                                                    <?php
                                                        $ambil=mysqli_query($koneksi,"SELECT * FROM jabatan");
                                                        while($jabatan=$ambil->fetch_assoc()){
                                                    ?>
                                                    <option value="<?php echo $jabatan['id_jabatan']?>" <?php if ($pegawai['id_jabatan']==$jabatan['id_jabatan']){?> selected <?php }; ?>><?php echo $jabatan['nama_jabatan']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $pegawai['alamat']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="no_telp" class="col-sm-2 col-form-label">No. Telp</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No. Telp" value="0<?php echo $pegawai['no_telp']; ?>" required>
                                            </div>
                                        </div>

                                        <hr>

                                        <p><b>Data Akun Pegawai</b></p>

                                        <div class="form-group row">
                                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $penggunaPegawai['username']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 col-form-label">Kata Sandi</label>
                                            <div class="col-sm-9">
                                                <a href="pegawai_ubah_katasandi.php?id=<?php echo $pegawai['id_pegawai'];?>" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">Ubah Kata Sandi <i class="fa fa-key"></i></a>
                                            </div>
                                        </div>

                                        <input type="hidden" name='id_pengguna' value="<?php echo $pegawai['id_pengguna'];?>">
                                    
                                        <div class="text-center">
                                            <button class="btn btn-primary" name="ubah">
                                                Ubah
                                            </button>
                                        </div>
                                    </form>
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