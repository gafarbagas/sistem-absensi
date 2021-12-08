<?php
    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['role'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
        $ambilJabatan=mysqli_query($koneksi,"SELECT * FROM jabatan WHERE id_jabatan='$_GET[id]'");
        $jabatan=$ambilJabatan->fetch_assoc();
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-dark">Ubah Data Jabatan</h1>
</div>

<div class="row text-dark mb-5">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group row">
                        <label for="kode_jabatan" class="col-sm-2 col-form-label">Kode Jabatan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="kode_jabatan" id="kode_jabatan" placeholder="Kode Jabatan" value="<?php echo $jabatan['kode_jabatan']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama_jabatan" class="col-sm-2 col-form-label">Nama Jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" placeholder="Nama Jabatan" value="<?php echo $jabatan['nama_jabatan']; ?>" required>
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
            $kodeJabatan = $_POST['kode_jabatan'];
            $namaJabatan = $_POST['nama_jabatan'];
            if($kodeJabatan == $jabatan['kode_jabatan']){
                $query = "UPDATE jabatan SET nama_jabatan='$namaJabatan' WHERE id_jabatan='$_GET[id]'";
                $ubah = mysqli_query($koneksi, $query);
                if ($ubah) {
                    echo "<script>alert('Data berhasil diubah')</script>";
                    echo "<script>location='index.php?halaman=jabatan';</script>"; 
                }
                else{
                    echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                    echo "<script>location='index.php?halaman=jabatan-ubah&id=$jabatan[id_jabatan]';</script>";
                }
            }else{
                $cekJabatan = mysqli_query($koneksi, "SELECT * FROM jabatan WHERE kode_jabatan='$kodeJabatan'");
                $cek = mysqli_num_rows($cekJabatan);
                if($cek == 1){
                    echo "<script>alert('Kode Jabatan Tidak Boleh Sama')</script>";
                    echo "<script>location='index.php?halaman=jabatan-ubah&id=$jabatan[id_jabatan]';</script>";
                }else{
                    $query = "UPDATE jabatan SET kode_jabatan='$kodeJabatan',nama_jabatan='$namaJabatan' WHERE id_jabatan='$_GET[id]'";
                    $ubah = mysqli_query($koneksi, $query);
                    if ($ubah) {
                        echo "<script>alert('Data berhasil diubah')</script>";
                        echo "<script>location='index.php?halaman=jabatan';</script>"; 
                    }
                    else{
                        echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                        echo "<script>location='index.php?halaman=jabatan-ubah&id=$jabatan[id_jabatan]';</script>";
                    }
                }
            }
        }
    }
?>