<?php
    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['roles'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='beranda.php';</script>";
    }else{
        $ambilPegawai=mysqli_query($koneksi,"SELECT * from pegawai WHERE id_pegawai = $_GET[id]");
        $dataPengguna=$ambilPegawai->fetch_assoc();
        $idPengguna=$dataPengguna['id_pengguna'];

        $koneksi->query("DELETE FROM pegawai WHERE id_pegawai='$_GET[id]'");
        $koneksi->query("DELETE FROM pengguna WHERE id_pengguna='$idPengguna'");
        // echo($idPengguna);
        echo "<script>alert('Data pegawai terhapus');</script>";
        echo "<script>location='beranda.php?halaman=pegawai';</script>";
    }
?>
