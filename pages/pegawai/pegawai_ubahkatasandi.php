<?php
    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['roles'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='beranda.php';</script>";
    }else{
        $ambil=mysqli_query($koneksi,"SELECT * FROM pengguna WHERE id_pengguna='$_GET[id]'");
        $pengguna=$ambil->fetch_assoc();
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-dark">Ubah Kata Sandi Pengguna</h1>
</div>

<div class="row text-dark mb-5">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group row">
                        <label for="katasandibaru" class="col-sm-2 col-form-label">Kata Sandi Baru</label>
                        <div class="col-sm">
                            <input type="password" class="form-control" name="password" id="katasandibaru" placeholder="Password">
                            <div class="invalid-feedback">
                                Silahkan Masukan Kata Sandi Baru
                            </div>
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
            $password = $_POST['password'];

            $query = "UPDATE pengguna SET password='$password' WHERE id_pengguna='$_GET[id]'";
            $ubah = mysqli_query($koneksi, $query);

            if ($ubah) {
                echo "<script>alert('Data berhasil diubah')</script>";
                echo "<script>location='beranda.php?halaman=pengguna';</script>"; 
            }
            else{
                echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                echo "<script>window.location='signup.html'</script>";
            }
        }
    }
?>