<?php
$d = date('dms'); 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=laporan-rekap-presensi-".$d.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>   
<?php 
  
$setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();
$where = "";
if($filter_5!='') $where .= " AND LEFT(md_presensi.waktu,7) = '$filter_5'";
if($filter_3!='') $where .= " AND md_presensi.jenis '$filter_3'";
if($filter_4!='') $where .= " AND md_presensi.id_karyawan '$filter_4'";
if($filter_4!='') $where .= " AND md_presensi.id_karyawan '$filter_4'";

$cek_data_karyawan = $this->db->query("SELECT * FROM md_presensi LEFT JOIN md_karyawan ON md_presensi.id_karyawan = md_karyawan.id_karyawan
  WHERE 1=1 $where GROUP BY md_presensi.id_karyawan ORDER BY md_karyawan.nama_lengkap");
?>
<!DOCTYPE html>
<base href="<?php echo base_url(); ?>" />
<html>
<!-- <html lang="ar"> for arabic only -->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Cetak Rekap Presensi</title>
    <style>
      @media print {
        @page {                 
          /*sheet-size: 210mm 95mm;                                                */
          sheet-size: 210mm 297mm;                      
          margin-left: 0.2cm;
          margin-right: 0.2cm;
          margin-bottom: 0.5cm;
          margin-top: 0.5cm;               
        }
        .text-center{text-align: center;}
        .bold{font-weight: bold;}
        .table {
          width: 100%;
          max-width: 100%;
          border-collapse: collapse;
         /*border-collapse: separate;*/
        }
        .table-bordered tr td {
          border: 0.01em solid black;
          padding-left: 6px;
          padding-right: 6px;
          padding-top: 10px;
          padding-bottom: 10px;
        }
        body{
          transform: scale(2, 0.5);
          font-family: "Arial";
          font-size: 12pt;          
        }
        
      }
    </style>
  </head>
<body>
  <h1>Cetak Rekap Presensi Bulan <?=$filter_5?></h1>
  <table border="1" width="100%" align="center">    
    <tr>
      <th width="1%">No</th>
      <th>Nama Lengkap</th>
      <?php 
      for ($i=1; $i <= 31; $i++) { 
        echo "<td align='center'>$i</td>";
      }
      ?>
      <th width="10%">Hadir</th>      
      <th width="10%">Terlambat</th>      
      <th width="10%">Pulang Cepat</th>      
    </tr>
    <?php 
    $no=1;
    foreach($cek_data_karyawan->result() AS $dt_karyawan){
      echo "
      <tr>
        <td align='center'><strong>$no</strong></td>
        <td><strong>$dt_karyawan->nama_lengkap</strong></td>";
        $hadir=0;$telat=0;$pc=0;
        for ($i=1; $i <= 31; $i++) { 
          $tgls = sprintf('%02d', $i);
          $tgl = $filter_5."-".$tgls;
          $cekhadir = $this->db->query("SELECT waktu,telat FROM md_presensi WHERE LEFT(waktu,10) = '$tgl' AND id_karyawan = '$dt_karyawan->id_karyawan' AND jenis='datang'");
          $waktu_datang = ($cekhadir->num_rows()>0)?substr($cekhadir->row()->waktu,11,5):'-';
          $cektelat = ($cekhadir->num_rows()>0)?$cekhadir->row()->telat:0;
          $telat+=$cektelat;

          $cekpulang = $this->db->query("SELECT waktu,telat FROM md_presensi WHERE LEFT(waktu,10) = '$tgl' AND id_karyawan = '$dt_karyawan->id_karyawan' AND jenis='pulang'");
          $waktu_pulang = ($cekpulang->num_rows()>0)?substr($cekpulang->row()->waktu,11,5):'-';
          $cekpc = ($cekpulang->num_rows()>0)?$cekpulang->row()->telat:0;
          $pc+=$cekpc;

          if($waktu_datang!='-'||$waktu_pulang!='-') $hadir++;
          
          echo "<td align='center'>$waktu_datang <br> $waktu_pulang</td>";
        }
        echo "
        <td align='center'>$hadir</td>
        <td align='center'>$telat</td>
        <td align='center'>$pc</td>
      </tr>
      ";
      $no++;
    }
    ?>
  </table>
</body>