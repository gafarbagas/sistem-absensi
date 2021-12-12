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
                                                        <a href="absensi_pegawai.php?id=<?php echo $pegawai['id_pegawai'];?>" class="btn btn-sm btn-info shadow-sm mb-1"><i class="fa fa-eye"></i> Lihat Absensi</a>
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

<?php
    }
?>