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

    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['role'] != 'Admin'){
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
    <title>Beranda</title>

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
                        <h1 class="h3 text-dark">Jam Kerja</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm">
                            <div class="card">
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
                                echo "<script>location='jamkerja.php';</script>"; 
                            }
                            else{
                                echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                                echo "<script>location='jamkerja.php';</script>";
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

</body>

</html>

<?php
    }
?>