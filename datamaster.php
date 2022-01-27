<?php 
    session_start();
    $koneksi = mysqli_connect("localhost","root","","db_absensi");
    // include 'tgl-indo.php';
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
    <title>Data Master</title>

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
                        <h1 class="h3 text-dark">Data Master</h1>
                    </div>

                    <div class="row text-dark mb-3">
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-header">
                                    <h1 class="h5 text-dark">Jam Kerja</h1>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover table-sm text-dark nowrap">
                                        <thead class="thead">
                                            <tr>
                                                <th>#</th>
                                                <th>Awal</th>
                                                <th>Akhir</th>
                                                <th width=53px>Aksi</th>
                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php 
                                            $ambil=mysqli_query($koneksi,"SELECT * from jam_kerja order by id_jam_kerja ASC");
                                            while($jamKerja=$ambil->fetch_assoc()){
                                        ?>
                                            <tr>
                                                <td><?php echo $jamKerja['nama_jam_kerja'] ?></td>
                                                <td><?php echo date("H:i", strtotime($jamKerja['awal'])) ?></td>
                                                <td><?php echo date("H:i", strtotime($jamKerja['akhir'])) ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#jamkerja<?php echo $jamKerja['id_jam_kerja'];?>">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="jamkerja<?php echo $jamKerja['id_jam_kerja'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Ubah Jam Kerja <?php echo $jamKerja['nama_jam_kerja'];?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="" method="POST">
                                                            <div class="modal-body">
                                                                <div class="form-group row mt-3">
                                                                    <div class="col-sm">
                                                                        <input type="time" class="form-control" name="awal" id="awal" placeholder="Awal" value="<?php echo $jamKerja['awal']; ?>" required>
                                                                    </div>
                                                                    <div class="col-sm-1 mt-1">
                                                                        <i class="fa fa-minus"></i>
                                                                    </div>
                                                                    <div class="col-sm">
                                                                        <input type="time" class="form-control" name="akhir" id="akhir" placeholder="Akhir" value="<?php echo $jamKerja['akhir']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name='id_jam_kerja' value="<?php echo $jamKerja['id_jam_kerja']?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col">
                                            <h1 class="h5 text-dark">Cuti</h1>
                                        </div>
                                        <div class="col text-right">
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ubahcuti">
                                                <i class="fa fa-pencil-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                <?php 
                                    $ambil=mysqli_query($koneksi,"SELECT * from jatah_cuti WHERE id_jatah_cuti= '1'");
                                    $jatahCuti=$ambil->fetch_assoc();
                                    echo "Jatah Cuti Tahunan: $jatahCuti[jatah_cuti] Hari"; 
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h1 class="h5 text-dark">Jabatan</h1>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="datamaster_jabatan_tambah.php" class="btn btn-primary btn-icon-split btn-sm mb-1">
                                            <span class="icon">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                            <span class="text">Tambah</span>
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm text-dark nowrap" width="100%" cellspacing="0" id="projecttable">
                                            <thead class="thead">
                                                <tr>
                                                    <th width=25px>No.</th>
                                                    <th>Kode Jabatan</th>
                                                    <th>Nama Jabatan</th>
                                                    <th width=53px>Aksi</th>
                                                    
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php 
                                                $nomor=1;
                                                $ambil=mysqli_query($koneksi,"SELECT * from jabatan order by id_jabatan ASC");
                                                while($jabatan=$ambil->fetch_assoc()){
                                            ?>
                                                <tr>
                                                    <td><?php echo $nomor++ ?>.</td>
                                                    <td><?php echo $jabatan['kode_jabatan'] ?></td>
                                                    <td><?php echo $jabatan['nama_jabatan'] ?></td>
                                                    <td>
                                                        <a href="datamaster_jabatan_ubah.php?id=<?php echo $jabatan['id_jabatan'];?>" class="btn btn-sm btn-info shadow-sm mb-1"><i class="fa fa-pencil-alt"></i></a>
                                                        <a href="datamaster_jabatan_hapus.php?id=<?php echo $jabatan['id_jabatan'];?>" class="btn btn-sm btn-danger mb-1 delete-confirm"><i class="fa fa-trash"></i></a>
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

                    <div class="modal fade" id="ubahcuti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content text-dark">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ubah Cuti</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <div class="form-group row mt-3">
                                            <label for="jatah_cuti" class="col-sm-4 col-form-label">Jatah Cuti Tahunan</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" name="jatah_cuti" id="jatah_cuti" placeholder="Jatah Cuti" value="<?php echo $jatahCuti['jatah_cuti']; ?>" required>
                                            </div>
                                            <label class="col-sm col-form-label">Hari</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" name="ubahcuti" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php 
                        if (isset($_POST['ubah'])) 
                        {
                            $awal = $_POST['awal'];
                            $akhir = $_POST['akhir'];
                            $idJamKerja = $_POST['id_jam_kerja'];
                            $query = "UPDATE jam_kerja SET awal='$awal',akhir='$akhir' WHERE id_jam_kerja='$idJamKerja'";
                            $ubah = mysqli_query($koneksi, $query);
                            if ($ubah) {
                                echo "<script>alert('Data berhasil diubah')</script>";
                                echo "<script>location='datamaster.php';</script>"; 
                            }
                            else{
                                echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                echo "<script>location='datamaster.php';</script>";
                            }
                        }

                        if (isset($_POST['ubahcuti'])) 
                        {
                            $jatahCuti = $_POST['jatah_cuti'];
                            $query = "UPDATE jatah_cuti SET jatah_cuti='$jatahCuti' WHERE id_jatah_cuti='1'";
                            $ubah = mysqli_query($koneksi, $query);
                            if ($ubah) {
                                echo "<script>alert('Data berhasil diubah')</script>";
                                echo "<script>location='datamaster.php';</script>"; 
                            }
                            else{
                                echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                echo "<script>location='datamaster.php';</script>";
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