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
        $ambilIzin = mysqli_query($koneksi, "SELECT * FROM izin WHERE id_izin='$_GET[id]'");
        $izin=$ambilIzin->fetch_assoc();
        $idPegawai = $izin['id_pegawai'];
        $awal = $izin['awal_izin'];
        $akhir = $izin['akhir_izin'];
        
        $ambilAbsensi = mysqli_query($koneksi,"SELECT count(*) as total FROM absensi WHERE id_pegawai ='$idPegawai' AND keterangan = 'Izin' AND tanggal BETWEEN '$awal' AND '$akhir'");
        $data=mysqli_fetch_assoc($ambilAbsensi);
        $cek = $data['total'];

        if($cek > 0){
            $koneksi->query("DELETE FROM absensi WHERE id_pegawai ='$idPegawai' AND keterangan = 'Izin' AND tanggal BETWEEN '$awal' AND '$akhir'");
            $koneksi->query("DELETE FROM izin WHERE id_izin='$_GET[id]'");
            echo "<script>alert('Data izin terhapus');</script>";
            echo "<script>location='izin.php';</script>";
        }else{
            $koneksi->query("DELETE FROM izin WHERE id_izin='$_GET[id]'");
            echo "<script>alert('Data izin terhapus');</script>";
            echo "<script>location='izin.php';</script>";
        }
    }
?>