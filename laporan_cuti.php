<?php
session_start();
$koneksi = mysqli_connect("localhost","root","","db_absensi");
require_once("asset/dompdf/autoload.inc.php");
require_once("tgl-indo.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->add_info('Title', 'Laporan Absensi');
$ambilCuti = mysqli_query($koneksi,"SELECT * FROM cuti JOIN pegawai ON cuti.id_pegawai = pegawai.id_pegawai ORDER BY id_cuti DESC");
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
<center><h3>Daftar Cuti Pegawai</h3></center><br/>
<table border="1" style="border-collapse: collapse" cellpadding=4px width="100%">
    <tr>
        <th width=25px>No.</th>
        <th>Nama Pegawai</th>
        <th>Jenis Cuti</th>
        <th>Awal Cuti</th>
        <th>Akhir Cuti</th>
        <th>Status</th>
    </tr>';
    $no = 1;
    if(mysqli_num_rows($ambilCuti)!=0){
        while($row = mysqli_fetch_array($ambilCuti)){
            $html .= "
            <tr>
                <td>".$no.".</td>
                <td>".$row['nama_pegawai']."</td>
                <td>".$row['jenis_cuti']."</td>
                <td>".tgl_indonesia($row['awal_cuti'])."</td>
                <td>".tgl_indonesia($row['akhir_cuti'])."</td>
                <td>".$row['status']."</td>
            </tr>";
            $no++;
        }
    }else{
        $html .= '
                        <tr>
                            <td colspan=6 align=center>Tidak ada cuti</td>
                        </tr>
                    ';
    }
$html .= "</table>";
$html .= "</html>";
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("laporan_cuti.pdf",array("Attachment" => false));
?>