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
    <title>Laporan</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Laporan</h1>
                    </div>

                    <div class="row text-dark mb-5">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs" id="card-list" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#absensi" role="tab" aria-controls="absensi" aria-selected="true">Absensi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"  href="#cutisakit" role="tab" aria-controls="cutisakit" aria-selected="false">Cuti dan Izin Sakit</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="absensi" role="tabpanel">
                                            <form action="" method="POST" target="_blank">
                                                <div class="form-group">
                                                    <label for="nama_pegawai" class="col-form-label">Nama Pegawai</label>
                                                    <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" placeholder="Nama Pegawai" autocomplete="off">
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label col-sm-2">Bulan</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" name="bulan">
                                                            <?php
                                                                $ambilBulan = mysqli_query($koneksi,"SELECT * FROM bulan");
                                                                while($bulan=$ambilBulan->fetch_assoc()){
                                                                    echo"<option value=$bulan[id]>$bulan[nama_bulan]</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <label class="col-form-label col-sm-2">Tahun</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" name="tahun">
                                                            <?php
                                                                $tahunNow = date('Y');
                                                                $ambilTahun = mysqli_query($koneksi,"SELECT * FROM tahun");
                                                                while($tahun=$ambilTahun->fetch_assoc()){
                                                            ?>
                                                                <option value="<?php echo $tahun['tahun']?>" <?php if ($tahun['tahun']==$tahunNow){?> selected <?php }; ?>><?php echo $tahun['tahun']?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row text-center">
                                                    <div class="col-sm">
                                                        <button class="btn btn-secondary btn-icon-split mb-1" type="submit" name="absensi">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-print"></i>
                                                            </span>
                                                            <span class="text">Cetak</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane" id="cutisakit" role="tabpanel"  aria-labelledby="cutisakit-tab">
                                            <form action="" method="POST" target="_blank">
                                                <div class="form-group">
                                                    <label for="jenis_laporan" class="col-form-label">Jenis Laporan</label>
                                                    <select class="form-control" name="jenis_laporan" id="jenis_laporan">
                                                        <option value="cuti">Cuti</option>
                                                        <option value="izinsakit">Izin Sakit</option>
                                                    </select>
                                                </div>
                                                <div class="row text-center">
                                                    <div class="col-sm">
                                                        <button class="btn btn-secondary btn-icon-split mb-1" type="submit" name="cutisakit">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-print"></i>
                                                            </span>
                                                            <span class="text">Cetak</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        if(isset($_POST['absensi'])){
                            $namaPegawai = $_POST['nama_pegawai'];
                            $bulan = $_POST['bulan'];
                            $tahun = $_POST['tahun'];
                            echo "<script>location='laporan_absensi.php?nama_pegawai=$namaPegawai&bulan=$bulan&tahun=$tahun';</script>";
                        }

                        if(isset($_POST['cutisakit'])){
                            $jenis_laporan = $_POST['jenis_laporan'];
                            if($jenis_laporan == "cuti"){
                                echo "<script>location='laporan_cuti.php'</script>";
                            }elseif($jenis_laporan == "izinsakit"){
                                echo "<script>location='laporan_izinsakit.php'</script>";
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
    <script>
    $('#card-list a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#nama_pegawai').typeahead({
                source: function(query, result){
                    $.ajax({
                        url:"laporan_autocomplete.php",
                        method:"POST",
                        data:{query:query},
                        dataType:"json",
                        success:function(data){
                            result($.map(data, function(item){
                                return item;
                            }));
                        }
                    })
                }
            });
        });
    </script>

</body>

</html>