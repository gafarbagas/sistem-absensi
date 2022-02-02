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
    if($userLogin['role']=='Pegawai'){
        $ambilPegawai=mysqli_query($koneksi,"SELECT * FROM pegawai WHERE id_pengguna = $_SESSION[id_pengguna]");
        $pegawai=$ambilPegawai->fetch_assoc();
        $idPegawai=$pegawai['id_pegawai'];
    }
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
    <title>Izin</title>

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
                        <h1 class="h3 text-dark">Izin</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-sm">
                            <div class="card">
                                <?php
                                    if($userLogin['role'] == 'Pegawai'){
                                ?>
                                <div class="card-header py-3">
                                    <a href="izin_pengajuan.php" class="btn btn-primary btn-icon-split btn-sm mb-1">
                                        <span class="icon">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Tambah</span>
                                    </a>
                                </div>
                                <?php
                                    }
                                ?>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm text-dark nowrap" width="100%" cellspacing="0" id="projecttable">
                                            <thead class="thead">
                                                <tr>
                                                    <th width=25px>No.</th>
                                                    <?php
                                                        if($userLogin['role'] == 'Admin'){
                                                            echo "<th>Nama Pegawai</th>";
                                                        }
                                                    ?>
                                                    <th>Tanggal Awal Izin</th>
                                                    <th>Tanggal Akhir Izin</th>
                                                    <th>Status</th>
                                                    <th width=53px>Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php 
                                                $nomor=1;
                                                if($userLogin['role'] == 'Admin'){
                                                    $ambilIzin=mysqli_query($koneksi,"SELECT * FROM izin JOIN pegawai ON izin.id_pegawai = pegawai.id_pegawai ORDER BY id_izin DESC");
                                                }elseif($userLogin['role'] == 'Pegawai'){
                                                    $ambilIzin=mysqli_query($koneksi,"SELECT * FROM izin WHERE id_pegawai=$idPegawai ORDER BY id_izin DESC");
                                                }
                                                while($izin=$ambilIzin->fetch_assoc()){
                                            ?>
                                                <tr>
                                                    <td><?php echo $nomor++ ?>.</td>
                                                    <?php
                                                        if($userLogin['role'] == 'Admin'){
                                                            echo "<td>$izin[nama_pegawai]</td>";
                                                        }
                                                    ?>
                                                    <td><?php echo tgl_indonesia($izin['awal_izin']) ?></td>
                                                    <td><?php echo tgl_indonesia($izin['akhir_izin']) ?></td>
                                                    <td>
                                                        <?php if ($izin['status_izin'] == "Belum Dikonfirmasi") {
                                                            echo "<span class='badge badge-secondary'>$izin[status_izin]</span>";
                                                        }elseif ($izin['status_izin'] == "Ditolak") {
                                                            echo "<span class='badge badge-danger'>$izin[status_izin]</span>";
                                                        }elseif ($izin['status_izin'] == "Disetujui") {
                                                            echo "<span class='badge badge-success'>$izin[status_izin]</span>";
                                                        }?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        if($userLogin['role'] == 'Admin'){
                                                    ?>
                                                            <a href="izin_konfirmasi.php?id=<?php echo $izin['id_izin'];?>" class="btn btn-success btn-sm mb-1"><i class="fa fa-check"></i></a>
                                                            <a href="izin_hapus.php?id=<?php echo $izin['id_izin'];?>" class="btn btn-danger btn-sm delete-confirm mb-1"><i class="fa fa-trash"></i></a>
                                                    <?php
                                                        }else{
                                                            if($izin['status_izin'] == "Belum Dikonfirmasi"){
                                                                echo"<a href='izin_editpengajuan.php?id=$izin[id_izin]' class='btn btn-info btn-sm'><i class='fa fa-pencil-alt'></i></a>";
                                                            }else{
                                                                echo"<button class='btn btn-info btn-sm disabled'><i class='fa fa-pencil-alt'></i></button>";
                                                            }
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