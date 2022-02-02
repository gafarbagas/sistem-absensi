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
    <title>Ubah Pengguna</title>

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
                        <h1 class="h3 text-dark">Ubah Kata Sandi</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group row">
                                            <label for="katasandi" class="col-sm-4 col-form-label">Kata Sandi Lama</label>
                                            <div class="col-sm">
                                                <input type="password" class="form-control" name="katasandi" id="katasandi" placeholder="Kata Sandi Lama" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="katasandibaru" class="col-sm-4 col-form-label">Kata Sandi Baru</label>
                                            <div class="col-sm">
                                                <input type="password" class="form-control" name="katasandibaru" id="katasandibaru" placeholder="Kata Sandi Baru" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="konfirmasi_katasandibaru" class="col-sm-4 col-form-label">Konfirmasi Kata Sandi Baru</label>
                                            <div class="col-sm">
                                                <input type="password" class="form-control" name="konfirmasi_katasandibaru" id="konfirmasi_katasandibaru" placeholder="Konfirmasi Kata Sandi Baru" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm text-center">
                                                <button class="btn btn-primary" name="ubah" type="submit">Ubah</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if (isset($_POST['ubah'])) 
                        {
                            $katasandi = $_POST['katasandi'];
                            $katasandibaru = $_POST['katasandibaru'];
                            $konfirmasi_katasandibaru = $_POST['konfirmasi_katasandibaru'];

                            if($userLogin['password'] == $katasandi){
                                if($katasandi == $katasandibaru){
                                    echo "<script>alert('Kata sandi lama dan baru tidak boleh sama')</script>";
                                    echo "<script>location='ubahkatasandi.php';</script>"; 
                                }elseif($konfirmasi_katasandibaru != $katasandibaru){
                                    echo "<script>alert('Konfirmasi kata sandi tidak cocok')</script>";
                                    echo "<script>location='ubahkatasandi.php';</script>";
                                }else{
                                    $query = "UPDATE pengguna SET password='$katasandibaru' WHERE id_pengguna='$_SESSION[id_pengguna]'";
                                    $ubah = mysqli_query($koneksi, $query);
        
                                    if ($ubah) {
                                        echo "<script>alert('Kata sandi berhasil diubah')</script>";
                                        echo "<script>location='index.php';</script>"; 
                                    }
                                    else{
                                        echo "<script>alert('Anda gagal mengubah data, silahkan ulangi')</script>";
                                        echo "<script>location='ubahkatasandi.php';</script>";
                                    }
                                }
                            }else{
                                echo "<script>alert('Kata sandi lama salah')</script>";
                                echo "<script>location='ubahkatasandi.php';</script>"; 
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