<?php 
    session_start();
    // script koneksi
    $koneksi = mysqli_connect("localhost","root","","db_absensi");

    if (isset($_SESSION['id_pengguna'])) 
    {
            echo "<script>alert('Anda sedang login');</script>";
            echo "<script>location='index.php';</script>";
            exit();
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

    <title>Login Sistem Absensi</title>

    <?php
        include('include/include-style.php');
    ?>

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5 my-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                        <h1 class="h5 text-gray-900 mb-4">Sistem Absensi</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" placeholder="Masukkan Username" name="username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <button name="login" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <br>

                                    <?php 
                                        if (isset($_POST['login']))
                                        {
                                            $sql=mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$_POST[username]' AND password='$_POST[password]'");
                                            if( mysqli_num_rows($sql) > 0 ){
                                                $data=mysqli_fetch_assoc($sql);
                                                $_SESSION['id_pengguna']=$data['id_pengguna'];
                                                echo "<div class='alert alert-info'>Anda berhasil Login</div>";               
                                                echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=beranda'>";         
                                            }
                                            else{
                                                echo "<div class='alert alert-danger'>Login Gagal</div>";               
                                                echo "<meta content='1;url=login.php'>"; 
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        include('include/include-script.php');
    ?>

</body>

</html>