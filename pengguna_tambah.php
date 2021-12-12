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
                        <h1 class="h3 text-dark">Tambah Data Pengguna</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="">
                                        
                                        <div class="form-group row">
                                            <label for="name"  class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm">
                                                <input type="text" class="form-control" name="nama_pengguna" id="name" placeholder="Nama" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="role"  class="col-sm-2 col-form-label">Hak Akses</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="role" id="role" value="Admin" disabled>
                                            </div>
                                        </div>
                                        
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
                                            
                                
                                        <div class="row">
                                            <div class="col-sm text-center">
                                                <button class="btn btn-primary" name="tambah">Tambah</button>
                                            </div>
                                        </div>
                                
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php 
                        if (isset($_POST['tambah'])) 
                        {
                            $nama_pengguna = $_POST['nama_pengguna'];
                            $role = 'Admin';
                            $username = $_POST['username'];
                            $password = $_POST['password'];

                            $cekPengguna = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$username'");
                            $cek = mysqli_num_rows($cekPengguna);
                            if($cek == 1){
                                echo "<script>alert('Username Sudah Digunakan')</script>";
                                echo "<script>location='pengguna_tambah.php';</script>";
                            }else{
                                $query = "INSERT INTO pengguna(nama_pengguna,role,username,password) VALUES ('$nama_pengguna','$role','$username','$password')";
                                $tambah = mysqli_query($koneksi, $query);   
                                if ($tambah) {
                                    echo "<script>alert('Data berhasil ditambahkan')</script>";
                                    echo "<script>location='pengguna.php';</script>"; 
                                }
                                else{
                                    echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                    echo "<script>window.location='pengguna_tambah.php'</script>";
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