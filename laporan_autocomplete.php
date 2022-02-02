<?php
    $koneksi = mysqli_connect("localhost","root","","db_absensi");
    $request = mysqli_real_escape_string($koneksi, $_POST["query"]);
    $query = "SELECT * FROM pegawai WHERE nama_pegawai LIKE '%".$request."%'";

    $result = mysqli_query($koneksi, $query);
    
    $pegawai = array();
    
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $pegawai[] = $row["nama_pegawai"];
        }
        echo json_encode($pegawai);
    }
?>