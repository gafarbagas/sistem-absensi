<?php
    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['role'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
?>
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

            $query = "INSERT INTO pengguna(nama_pengguna,role,username,password) VALUES ('$nama_pengguna','$role','$username','$password')";
            $tambah = mysqli_query($koneksi, $query);

            if ($tambah) {
                echo "<script>alert('Data berhasil ditambahkan')</script>";
                echo "<script>location='index.php?halaman=pengguna';</script>"; 
            }
            else{
                echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                echo "<script>window.location='index.php?halaman=pengguna-tambah'</script>";
            }
        }
    }
?>