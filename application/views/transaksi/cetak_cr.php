<!-- <body onload="window.print();"> -->
<?php 
function mata_uang($a){      
  if(is_numeric($a) AND $a != 0 AND $a != ""){
    return number_format($a, 0, ',', '.');
  }else{
    return $a;
  }
}
$kode = decrypt_url($kode);
$setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();
$cek_data = $this->db->query("SELECT md_invoice.*, md_brand.bg_cr, md_client.no_mou, md_client.alamat, md_client.nama_faskes FROM md_invoice
  LEFT JOIN md_client ON md_invoice.id_client = md_client.id
  LEFT JOIN md_brand ON md_invoice.id_brand = md_brand.id
  WHERE md_invoice.kode = '$kode'")->row();
?>
<!DOCTYPE html>
<base href="<?php echo base_url(); ?>" />
<html>
<!-- <html lang="ar"> for arabic only -->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Cetak Invoice</title>
    <style>
      @media print {
        @page {                 
          /*sheet-size: 210mm 95mm;                                                */
          sheet-size: 210mm 297mm;                      
          margin-left: 0.2cm;
          margin-right: 0.2cm;
          margin-bottom: 0.5cm;
          margin-top: 0.5cm;     
          background-image: url("<?php echo base_url() ?>/assets/uploads/sites/<?=$cek_data->bg_cr?>");                               
        }
        .text-center{text-align: center;}
        .bold{font-weight: bold;}        
        body{
          transform: scale(2, 0.5);
          font-family: "Arial";
          font-size: 12pt;          
        }
        
      }
    </style>
  </head>
<body>
  <table border="0" width="90%" align="center" style="padding-top:40px;">    
    <tr>
      <td width="50%" colspan="3" valign="top"></td>
      <td colspan="2" align="right" valign="top">
        <b>Nomor: </b> <?=$cek_data->kode_cr?> <br>        
      </td>      
    </tr>
    <tr>
      <td><br><br><br></td>
    </tr>
    <tr>
      <td align="center" colspan="5">
        <h2>CUSTOMER RECEIPT</h2>
      </td>
    </tr>
    <tr>
      <td><br><br></td>
    </tr>
    <tr>
      <td colspan="5">
        Bukti Pembayaran <br>
        <b><?php echo $cek_data->nama_faskes ?></b><br>
        <?php echo $cek_data->alamat ?>
      </td>
    </tr>
    
    <tr>
      <td colspan="5"> <br> 
        <table border="0" class="table table-bordered" width="100%">
          <tr>
            <th style="padding-top: 10px;padding-bottom: 10px;">No.Ref Transaksi</th>            
            <th>Nomor Invoice</th>                        
            <th>Tanggal Pembayaran</th>                                    
          </tr>      
          <tr>
            <td colspan="3">
              <hr>
            </td>
          </tr>
          <tr>
            <td align="center"><?=$cek_data->no_ref?></td>
            <td align="center"><?=$cek_data->kode?></td>
            <td align="center"><?=tgl_indo($cek_data->tgl_invoice)?></td>
          </tr>
          <tr>
            <td colspan="3">
              <hr>
            </td>
          </tr>                
        </table>                   
      </td>
    </tr>  

    <tr>
      <td colspan="5">
        <b>
        <?php echo $cek_data->keterangan ?> <br>
        <?php echo $cek_data->nama_faskes ?></b><br>
        <?php if($cek_data->id_brand==1){ ?>
        Periode <?php echo $cek_data->periode ?>
        <?php } ?>
      </td>
    </tr>  
    <tr>
      <td colspan="2"></td>
      <td colspan="3">
        <h3>TOTAL PEMBAYARAN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rp <?php echo mata_uang_help($cek_data->total) ?></h3>        
      </td>
    </tr>  
  </table>  
  <br>  
</body>