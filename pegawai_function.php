<?php
    if (isset($_POST['tambah'])) 
    {
        $namaPegawai = $_POST['nama_pegawai'];
        $nip = $_POST['nip'];
        $idJabatan = $_POST['id_jabatan'];
        $alamat = $_POST['alamat'];
        $noTelp = $_POST['no_telp'];
        $role = 'Pegawai';
        $username = $_POST['username'];
        $password = $_POST['password'];

        $koneksi->query("INSERT INTO pengguna(nama_pengguna,role,username,password) VALUES ('$namaPegawai','$role','$username','$password')");

        $idPengguna = $koneksi->insert_id;

        $query2 = "INSERT INTO pegawai(nama_pegawai,nip,id_jabatan,alamat,no_telp,id_pengguna) VALUES ('$namaPegawai','$nip','$idJabatan','$alamat','$noTelp','$idPengguna')";
        $tambah2 = mysqli_query($koneksi, $query2);

        if ($tambah2) {
            echo "<script>alert('Data berhasil ditambahkan')</script>";
            echo "<script>location='pegawai.php';</script>"; 
        }
        else{
            $koneksi->query("DELETE FROM pengguna WHERE id_pengguna='$idPengguna'");
            echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
            echo "<script>window.location='pegawai_tambah.php'</script>";
        }
    }

    if (isset($_POST['ubah'])) 
    {
        $nip = $_POST['nip'];
        $namaPegawai = $_POST['nama_pegawai'];
        $idJabatan = $_POST['id_jabatan'];
        $alamat = $_POST['alamat'];
        $noTelp = $_POST['no_telp'];
        $username = $_POST['username'];
        $idPengguna = $_POST['id_pengguna'];

        // echo $penggunaPegawai['username'];

        if($username == $penggunaPegawai['username']){
            $query1 = "UPDATE pegawai SET nip='$nip',nama_pegawai='$namaPegawai',id_jabatan='$idJabatan',alamat='$alamat',no_telp='$noTelp' WHERE id_pegawai='$_GET[id]'";
            $ubah1 = mysqli_query($koneksi, $query1);

            $query2 = "UPDATE pengguna SET nama_pengguna='$namaPegawai' WHERE id_pengguna='$idPengguna'";
            $ubah2 = mysqli_query($koneksi, $query2);

            if ($ubah2) {
                echo "<script>alert('Data berhasil diubah')</script>";
                echo "<script>location='pegawai.php';</script>"; 
            }
            else{
                echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                echo "<script>location='pegawai_ubah.php?id=$_GET[id]';</script>";
            }
        }else{
            $cekPengguna = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$username'");
            $cek = mysqli_num_rows($cekPengguna);
            if($cek == 1){
                echo "<script>alert('Username Sudah Digunakan')</script>";
                echo "<script>location='pegawai_ubah.php?id=$_GET[id]';</script>";
            }else{
                $query1 = "UPDATE pegawai SET nip='$nip',nama_pegawai='$namaPegawai',id_jabatan='$idJabatan',alamat='$alamat',no_telp='$noTelp' WHERE id_pegawai='$_GET[id]'";
                $ubah1 = mysqli_query($koneksi, $query1);

                $query2 = "UPDATE pengguna SET nama_pengguna='$namaPegawai',username='$username' WHERE id_pengguna='$idPengguna'";
                $ubah2 = mysqli_query($koneksi, $query2);

                if ($ubah2) {
                    echo "<script>alert('Data berhasil diubah')</script>";
                    echo "<script>location='pegawai.php';</script>"; 
                }
                else{
                    echo "<script>alert('Anda gagal menambah data, silahkan ulangi')</script>";
                    echo "<script>location='pegawai_ubah.php?id=$_GET[id]';</script>";
                }
            }
        }
    }
?>