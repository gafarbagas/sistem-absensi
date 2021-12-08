<?php
    $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
    $pengguna=$ambil->fetch_assoc();
    if ($pengguna['role'] != 'Admin'){
        echo "<script>alert('Anda tidak memilik akses');</script>";
        echo "<script>location='index.php';</script>";
    }else{
        $koneksi->query("DELETE FROM pengguna WHERE id_pengguna='$_GET[id]'");

        echo "<script>alert('Data pengguna terhapus');</script>";
        echo "<script>location='index.php?halaman=pengguna';</script>";
    }
?>
