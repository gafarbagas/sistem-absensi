<?php
    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['role'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-dark">Data Absensi</h1>
</div>

<div class="row text-dark mb-5">
    <div class="col-sm">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-dark nowrap" width="100%" cellspacing="0" id="projecttable">
                    <thead class="thead">
                            <tr>
                                <th width=25px>No.</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th width=53px>Aksi</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                        <?php 
                            $nomor=1;
                            $sql="SELECT pegawai.id_pegawai AS id_pegawai, pegawai.nama_pegawai AS nama_pegawai, pegawai.nip AS nip, pegawai.alamat AS alamat, pegawai.no_telp AS no_telp, jabatan.nama_jabatan AS nama_jabatan FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan ORDER BY id_pegawai DESC";
                            $ambil=mysqli_query($koneksi,$sql);
                            while($pegawai=$ambil->fetch_assoc()){
                        ?>
                            <tr>
                            <td><?php echo $nomor++ ?>.</td>
                                <td><?php echo $pegawai['nip'] ?></td>
                                <td><?php echo $pegawai['nama_pegawai'] ?></td>
                                <td><?php echo $pegawai['nama_jabatan'] ?></td>
                                <td>
                                    <a href="index.php?halaman=absensi-pegawai&id=<?php echo $pegawai['id_pegawai'];?>" class="btn btn-sm btn-info shadow-sm mb-1"><i class="fa fa-eye"></i> Lihat Absensi</a>
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