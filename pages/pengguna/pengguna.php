<?php
    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['role'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-dark">Data Pengguna</h1>
</div>

<div class="row text-dark mb-5">
    <div class="col-md">
        <div class="card">
            <div class="card-header py-3">
                <a href="index.php?halaman=pengguna-tambah" class="btn btn-primary btn-icon-split btn-sm mb-1">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah</span>
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-dark nowrap" width="100%" cellspacing="0" id="projecttable">
                        <thead class="thead">
                            <tr>
                                <th width=25px>No.</th>
                                <th>Nama</th>
                                <th>Hak Akses</th>
                                <th>Username</th>
                                <th width=53px>Aksi</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                        <?php 
                            $nomor=1;
                            $ambil=mysqli_query($koneksi,"SELECT * FROM pengguna WHERE role='Admin' ORDER BY id_pengguna DESC");
                            while($pengguna=$ambil->fetch_assoc()){
                        ?>
                            <tr>
                                <td><?php echo $nomor++ ?>.</td>
                                <td><?php echo $pengguna['nama_pengguna'] ?></td>
                                <td><?php echo $pengguna['role'] ?></td>
                                <td><?php echo $pengguna['username'] ?></td>
                                <td>
                                    <a href="index.php?halaman=pengguna-ubah&id=<?php echo $pengguna['id_pengguna'];?>" class="btn btn-sm btn-info shadow-sm mb-1"><i class="fa fa-pencil-alt"></i></a>
                                    <?php
                                        if($pengguna['id_pengguna'] != $_SESSION['id_pengguna']){
                                    ?>
                                            <a href="index.php?halaman=pengguna-hapus&id=<?php echo $pengguna['id_pengguna'];?>" class="btn btn-sm btn-danger mb-1 delete-confirm"><i class="fa fa-trash"></i></a>
                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>