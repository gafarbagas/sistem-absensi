<?php
    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['role'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
        $ambil=mysqli_query($koneksi,"SELECT * FROM pengguna WHERE id_pengguna='$_GET[id]'");
        $pengguna=$ambil->fetch_assoc();
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-dark">Ubah Data Pengguna</h1>
</div>

<div class="row text-dark bm-5">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_pengguna" id="name" placeholder="Nama" value="<?php echo $pengguna['nama_pengguna']; ?>" required>
                        </div>
                    </div>
        
                    <div class="form-group row">
                        <label for="roles" class="col-sm-2 col-form-label">Hak Akses</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="roles" id="name" placeholder="Nama" value="<?php echo $pengguna['role']; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $pengguna['username']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Kata Sandi</label>
                        <div class="col-sm-9">
                            <a href="index.php?halaman=pengguna-ubah-kata-sandi&id=<?php echo $pengguna['id_pengguna'];?>" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">Ubah Kata Sandi <i class="fa fa-key"></i></a>
                        </div>
                    </div>
                
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
        if (isset($_POST['ubah'])) 
        {
            $namaPengguna = $_POST['nama_pengguna'];
            $username = $_POST['username'];

            if($username == $pengguna['username']){
                $query = "UPDATE pengguna SET nama_pengguna='$namaPengguna' WHERE id_pengguna='$_GET[id]'";
                $ubah = mysqli_query($koneksi, $query);
                if ($ubah) {
                    echo "<script>alert('Data berhasil diubah')</script>";
                    echo "<script>location='index.php?halaman=pengguna';</script>"; 
                }
                else{
                    echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                    echo "<script>location='index.php?halaman=pengguna-ubah&id=$pengguna[id_pengguna]';</script>";
                }
            }else{
                $cekPengguna = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$username'");
                $cek = mysqli_num_rows($cekPengguna);
                if($cek == 1){
                    echo "<script>alert('Username Sudah Digunakan')</script>";
                    echo "<script>location='index.php?halaman=pengguna-ubah&id=$pengguna[id_pengguna]';</script>";
                }else{
                    $query = "UPDATE pengguna SET username='$username',nama_pengguna='$namaPengguna' WHERE id_pengguna='$_GET[id]'";
                    $ubah = mysqli_query($koneksi, $query);
                    if ($ubah) {
                        echo "<script>alert('Data berhasil diubah')</script>";
                        echo "<script>location='index.php?halaman=pengguna';</script>"; 
                    }
                    else{
                        echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                        echo "<script>location='index.php?halaman=pengguna-ubah&id=$pengguna[id_pengguna]';</script>";
                    }
                }
            }
        }
    }
?>