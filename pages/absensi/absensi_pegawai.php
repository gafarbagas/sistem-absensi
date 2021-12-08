<?php
    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['role'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
        $sql="SELECT * FROM pegawai WHERE id_pegawai='$_GET[id]'";
        $dataPegawai=mysqli_query($koneksi,$sql);
        $pegawai=$dataPegawai->fetch_assoc();
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-dark">Absensi <?php echo $pegawai['nama_pegawai']?></h1>
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
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                        <?php 
                            $nomor=1;
                            // $sql="SELECT pegawai.nip AS nip, pegawai.nama_pegawai AS nama_pegawai, jabatan.nama_jabatan AS nama_jabatan, absensi.jam_masuk AS jam_masuk, absensi.jam_pulang AS jam_pulang FROM absensi JOIN pegawai ON absensi.id_pegawai=pegawai.id_pegawai JOIN jabatan ON jabatan.id_jabatan=pegawai.id_jabatan WHERE pegawai.id_pegawai='$_GET[id]' ORDER BY id_absensi DESC";
                            $sql="SELECT * FROM absensi WHERE id_pegawai='$_GET[id]' ORDER BY id_absensi DESC";
                            $dataAbsensi=mysqli_query($koneksi,$sql);
                            while($absensi=$dataAbsensi->fetch_assoc()){
                        ?>
                            <tr>
                            <td><?php echo $nomor++ ?>.</td>
                                <td><?php echo $absensi['tanggal'] ?></td>
                                <td><?php echo $absensi['jam_masuk'] ?></td>
                                <td><?php echo $absensi['jam_pulang'] ?></td>
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