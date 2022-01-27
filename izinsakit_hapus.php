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
        $ambilIzinSakit = mysqli_query($koneksi, "SELECT * FROM izin_sakit WHERE id_izin_sakit='$_GET[id]'");
        $izinSakit=$ambilIzinSakit->fetch_assoc();
        $idPegawai = $izinSakit['id_pegawai'];
        $awal = $izinSakit['awal_izin_sakit'];
        $akhir = $izinSakit['akhir_izin_sakit'];
        $file = "asset/document/".$izinSakit['bukti_izin_sakit'];
        if (file_exists($file)) {
            unlink($file);
        }
        
        $ambilAbsensi = mysqli_query($koneksi,"SELECT count(*) as total FROM absensi WHERE id_pegawai ='$idPegawai' AND keterangan = 'Izin Sakit' AND tanggal BETWEEN '$awal' AND '$akhir'");
        $data=mysqli_fetch_assoc($ambilAbsensi);
        $cek = $data['total'];

        if($cek > 0){
            $koneksi->query("DELETE FROM absensi WHERE id_pegawai ='$idPegawai' AND keterangan = 'Izin Sakit' AND tanggal BETWEEN '$awal' AND '$akhir'");
            $koneksi->query("DELETE FROM izin_sakit WHERE id_izin_sakit='$_GET[id]'");
            echo "<script>alert('Data izin sakit terhapus');</script>";
            echo "<script>location='izinsakit.php';</script>";
        }else{
            $koneksi->query("DELETE FROM izin_sakit WHERE id_izin_sakit='$_GET[id]'");
            echo "<script>alert('Data izin sakit terhapus');</script>";
            echo "<script>location='izinsakit.php';</script>";
        }
    }
?>