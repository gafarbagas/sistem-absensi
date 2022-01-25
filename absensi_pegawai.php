<?php 
    session_start();
    $koneksi = mysqli_connect("localhost","root","","db_absensi");
    include 'tgl-indo.php';
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
        $sql="SELECT * FROM pegawai WHERE id_pegawai='$_GET[id]'";
        $dataPegawai=mysqli_query($koneksi,$sql);
        $pegawai=$dataPegawai->fetch_assoc();
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
    <title>Absensi</title>

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
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php 
                                                $nomor=1;
                                                // $sql="SELECT pegawai.nip AS nip, pegawai.nama_pegawai AS nama_pegawai, jabatan.nama_jabatan AS nama_jabatan, absensi.jam_masuk AS jam_masuk, absensi.jam_pulang AS jam_pulang FROM absensi JOIN pegawai ON absensi.id_pegawai=pegawai.id_pegawai JOIN jabatan ON jabatan.id_jabatan=pegawai.id_jabatan WHERE pegawai.id_pegawai='$_GET[id]' ORDER BY id_absensi DESC";
                                                $sql="SELECT * FROM absensi WHERE id_pegawai='$_GET[id]' ORDER BY tanggal DESC";
                                                $dataAbsensi=mysqli_query($koneksi,$sql);
                                                while($absensi=$dataAbsensi->fetch_assoc()){
                                            ?>
                                                <tr>
                                                <td><?php echo $nomor++ ?>.</td>
                                                    <td><?php echo tgl_indonesia($absensi['tanggal']) ?></td>
                                                    <td>
                                                        <?php
                                                            if($absensi['keterangan'] == 'Cuti' || $absensi['keterangan'] == 'Izin Sakit'){
                                                                echo '-';
                                                            }else{
                                                                echo $absensi['jam_masuk'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            if($absensi['jam_pulang'] != NULL){
                                                                echo $absensi['jam_pulang'];
                                                            }else{
                                                                if($absensi['keterangan'] == 'Cuti' || $absensi['keterangan'] == 'Izin Sakit'){
                                                                    echo '-';
                                                                }else{
                                                                    echo 'Belum Absen Pulang';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $absensi['keterangan'] ?></td>
                                                    <td>
                                                        <?php
                                                            if($absensi['keterangan'] == 'Cuti' || $absensi['keterangan'] == 'Izin Sakit'){
                                                        ?>
                                                        
                                                        <?php
                                                            }else{
                                                        ?>
                                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editAbsensi<?php echo $absensi['id_absensi'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                                        <?php
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="editAbsensi<?php echo $absensi['id_absensi'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Ubah Keterangan Absensi</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="" method="post">
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-3">Tanggal</div>
                                                                    <div class="col-sm-9"><?php echo tgl_indonesia($absensi['tanggal']) ?></div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-3">Jam Masuk</div>
                                                                    <div class="col-sm-9"><?php echo $absensi['jam_masuk'] ?></div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-3">Jam Pulang</div>
                                                                    <div class="col-sm-9">
                                                                        <?php 
                                                                            if($absensi['jam_pulang'] != NULL){
                                                                                echo $absensi['jam_pulang'];
                                                                            }else{
                                                                                echo 'Belum Absen Pulang';
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="keterangan"  class="col-sm-3 col-form-label">Keterangan</label>
                                                                    <div class="col-sm-9">
                                                                        <select type="text" class="form-control" name="keterangan" id="keterangan" required>
                                                                            <option value="Tepat Waktu" <?php if ($absensi['keterangan'] == 'Tepat Waktu'){?> selected <?php }; ?>>Tepat Waktu</option>
                                                                            <option value="Terlambat" <?php if ($absensi['keterangan'] == 'Terlambat'){?> selected <?php }; ?>>Terlambat</option>
                                                                            <option value="Tidak Hadir" <?php if ($absensi['keterangan'] == 'Tidak Hadir'){?> selected <?php }; ?>>Tidak Hadir</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name='id_absensi' value="<?php echo $absensi['id_absensi']?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                    if(isset($_POST['ubah'])){
                                                        $keterangan = $_POST['keterangan'];
                                                        $idAbsensi = $_POST['id_absensi'];
                                                        $query = "UPDATE absensi SET keterangan='$keterangan' WHERE id_absensi='$idAbsensi'";
                                                        $ubah = mysqli_query($koneksi, $query);
                                                        if ($ubah) {
                                                            echo "<script>alert('Data berhasil diubah')</script>";
                                                            echo "<script>location='absensi_pegawai.php?id=$_GET[id]';</script>"; 
                                                        }
                                                        else{
                                                            echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                                            echo "<script>location='absensi_pegawai.php?id=$_GET[id]';</script>";
                                                        }
                                                    }
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script src="asset/js/sweetalert.js"></script>
    <script>
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Harap periksa kembali. Data yang akan dihapus tidak akan bisa kembali!",
                icon: 'warning',
                reverseButtons: true,
                showCancelButton: true,
                confirmButtonColor: '#888888',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                    swal("Updated!", "Your imaginary file has been Deleted.", "success");
                }
            });
        });
    </script>

</body>

</html>

<?php
    }
?>