<?php
session_start();
$koneksi = mysqli_connect("localhost","root","","db_absensi");
require_once("asset/dompdf/autoload.inc.php");
require_once("tgl-indo.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->add_info('Title', 'Laporan Absensi');
$ambilPegawai = mysqli_query($koneksi,"SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan WHERE nama_pegawai='$_GET[nama_pegawai]' ORDER BY id_pegawai DESC");
$pegawai=$ambilPegawai->fetch_assoc();
$idPegawai=$pegawai['id_pegawai'];
$query = mysqli_query($koneksi,"SELECT * FROM absensi WHERE id_pegawai = '$idPegawai' AND MONTH(tanggal)='$_GET[bulan]' AND YEAR(tanggal)= '$_GET[tahun]'");
$html = '
<table width="100%" style="font-size: 10pt">
    <tr>
        <td align=center><img src="asset/img/logo2.png" width="500px" height="auto" style="margin-bottom: 2px;" /></td>
    </tr>
    <tr>
        <td align=center><b>Jalan Rawa Bambu Raya No. 18 F. Lantai 3. Pasar Minggu</b></td>
    </tr>
    <tr>
        <td align=center><b>Kota Adm. Jakarta Selatan</b></td>
    </tr>
    <tr>
        <td align=center><b>DKI Jakarta 12520</b></td>
    </tr>
</table>
<hr>
<center><h3>Daftar Absensi Pegawai</h3></center><br/>
<table style="border-collapse: collapse" cellpadding=5px>
    <tr>
        <td>Nama Pegawai</td>
        <td>:</td>
        <td>'.$pegawai['nama_pegawai'].'</td>
    </tr>
    <tr>
        <td>NIP</td>
        <td>:</td>
        <td>'.$pegawai['nip'].'</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>'.$pegawai['nama_jabatan'].'</td>
    </tr>
</table>
<br>
<br>
<table border="1" style="border-collapse: collapse" cellpadding=4px width="100%">
    <tr>
        <th width=25px>No.</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Pulang</th>
        <th>Ketarangan</th>
    </tr>';
    $no = 1;
    if(mysqli_num_rows($query)!=0){
        while($row = mysqli_fetch_array($query)){
            $html .= "
            <tr>
                <td>".$no.".</td>
                <td>".tgl_indonesia($row['tanggal'])."</td>";
            if($row['keterangan'] == 'Cuti' || $row['keterangan'] == 'Izin Sakit'){
                $html .= "
                <td>--</td>
                <td>--</td>";
            }else{
                $html .= "
                <td>".$row['jam_masuk']."</td>
                <td>".$row['jam_pulang']."</td>";
            }
            $html .= "
            <td>".$row['keterangan']."</td>
            </tr>";
            $no++;
        }
    }else{
        $html .= '
                        <tr>
                            <td colspan=5 align=center>Tidak ada absensi</td>
                        </tr>
                    ';
    }
$html .= "</table>";
$html .= "</html>";
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("laporan_absensi.pdf",array("Attachment" => false));
?>