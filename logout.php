<?php
	session_start();
    $koneksi = mysqli_connect("localhost","root","","db_absensi");
	
	session_destroy();
	echo "<script>alert('Anda telah logout');</script>";
	echo "<script>location='login.php';</script>";
?>