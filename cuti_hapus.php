<?php
    session_start();
    $koneksi = mysqli_connect("localhost","root","","db_absensi");
    if (!isset($_SESSION['id_pengguna'])) 
    {
        echo "<script>alert('Anda harus login');</script>";
        echo "<script>location='login.php';</script>";
        exit();
    }

    $ambilUserLogin=mysqli_query($koneksi,"SELECT * FROM pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $userLogin=$ambilUserLogin->fetch_assoc();
    if ($userLogin['role'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
        $ambilcuti = mysqli_query($koneksi, "SELECT * FROM cuti WHERE id_cuti='$_GET[id]'");
        $cuti=$ambilcuti->fetch_assoc();
        // var_dump($cuti);
        $idPegawai = $cuti['id_pegawai'];
        $awal = $cuti['awal_cuti'];
        $akhir = $cuti['akhir_cuti'];
        $ambilAbsensi = mysqli_query($koneksi,"SELECT count(*) as total FROM absensi WHERE id_pegawai ='$idPegawai' AND keterangan = 'Cuti' AND tanggal BETWEEN '$awal' AND '$akhir'");
        $data=mysqli_fetch_assoc($ambilAbsensi);
        $cek = $data['total'];

        if($cek > 0){
            $koneksi->query("DELETE FROM absensi WHERE id_pegawai ='$idPegawai' AND keterangan = 'Cuti' AND tanggal BETWEEN '$awal' AND '$akhir'");
            $koneksi->query("DELETE FROM cuti WHERE id_cuti='$_GET[id]'");
            echo "<script>alert('Data cuti terhapus');</script>";
            echo "<script>location='cuti.php';</script>";
        }else{
            $koneksi->query("DELETE FROM cuti WHERE id_cuti='$_GET[id]'");
            echo "<script>alert('Data cuti terhapus');</script>";
            echo "<script>location='cuti.php';</script>";
        }
    }
?>