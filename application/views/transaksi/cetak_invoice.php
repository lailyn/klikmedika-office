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
$cek_data = $this->db->query("SELECT md_invoice.*, md_brand.bg_invoice, md_client.alamat, md_client.nama_faskes FROM md_invoice
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
          background-image: url("<?php echo base_url() ?>/assets/uploads/sites/<?=$cek_data->bg_invoice?>");                               
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
  <table border="0" width="90%" align="center" style="padding-top:200px;">    
    <tr>
      <td width="50%" valign="top">
        <b>
        Kepada: <br>
        <?php echo $cek_data->nama_faskes ?> <br>
        </b>
        <?php echo $cek_data->alamat ?>
      </td>
      <td valign="top">
        <b>No Invoice: </b> <?=$kode?> <br>
        <b>Tgl Invoice: </b> <?=tgl_indo($cek_data->tgl_invoice)?> <br>                      
        <b>Tgl Jatuh Tempo: </b> <?=tgl_indo(manipulate_time($cek_data->tgl_invoice,'days','5','+','Y-m-d'))?> <br>        
        <b>Periode: </b> <?=$cek_data->periode?> <br>        
      </td>      
    </tr>
    
    <tr>
      <td colspan="4"> <br> 
        <table border="1" class="table table-bordered" width="100%">
          <tr>
            <th style="padding-top: 10px;padding-bottom: 10px;">Item</th>            
            <th>Harga</th>                        
            <th>Qty</th>                        
            <th>Diskon</th>                                    
            <th>Sub Total</th>
          </tr>
          <?php 
          $subs=0; 
          $cek_item = $this->db->query("SELECT products.*, md_invoice_detail.*, md_invoice_detail.diskon AS disc, md_invoice.*, md_invoice.total FROM md_invoice_detail 
            INNER JOIN md_invoice ON md_invoice_detail.kode = md_invoice.kode
            INNER JOIN products ON md_invoice_detail.product_id = products.id
            WHERE md_invoice.kode = '$cek_data->kode'");
          foreach($cek_item->result() AS $tr){  
            $diskon = (!is_null($tr->disc) && $tr->disc>0)?$tr->disc:0;
            ?>
          <tr>
            <td><?php echo $tr->item ?></td>
            <td align='right'><?php echo mata_uang_help($tr->nominal) ?></td>
            <td align="center"><?php echo $tr->qty ?></td>
            <td align='right'><?php echo mata_uang_help($diskon) ?></td>            
            <td align='right'><b><?php echo mata_uang_help($sub = ($tr->nominal * $tr->qty) - $diskon) ?></b></td>            
          </tr>
          <?php $subs += $sub; } ?> 
          <tr>
            <td align='right' colspan="4"><b>Sub Total</b></td>
            <td align='right'><b><?php echo mata_uang($subs) ?></b></td>            
          </tr>     
          <?php if(!is_null($cek_data->diskon) && $cek_data->diskon>0){ ?>
          <tr>
            <td align='right' colspan="4"><b>Diskon</b></td>
            <td align='right'><b><?php echo mata_uang($cek_data->diskon) ?></b></td>            
          </tr>  
          <tr>
            <td align='right' colspan="4"><b>Total</b></td>
            <td align='right'><b><?php echo mata_uang($subs - $cek_data->diskon) ?></b></td>            
          </tr>  
          <?php } ?>   
          <?php if(!is_null($cek_data->ppn) && $cek_data->ppn>0){ ?>
          <tr>
            <td align='right' colspan="4"><b>PPN 11%</b></td>
            <td align='right'><b><?php echo mata_uang($cek_data->ppn) ?></b></td>            
          </tr>        
          <?php }else{ ?>          
          <tr>
            <td align='right' colspan="4"><b>PPN</b></td>
            <td align='right'><b>-</b></td>            
          </tr>        
          <?php } ?>
          <tr>
            <td align='right' colspan="4"><b>Grand Total</b></td>
            <td align='right'><b><?php echo mata_uang($cek_data->total) ?></b></td>            
          </tr>              
        </table>                   
      </td>
    </tr>    
  </table>  
  <br>
  <table width="90%" border="0" align="center">      
    <tr>
      <td width="60%"><i></i></td>   
      <td>Jambi, <?php echo gmdate(" d F Y", time()+60*60*7); ?></td>
    </tr>
    
    <tr>
      <td></td>
      <td><?=$setting->perusahaan ?></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td>
        <img src="assets/im493/<?=$setting->banner?>" width="100px">
      </td>
    </tr>
    <tr>
      <td></td>
      <td><u><b><?=strtoupper($setting->admin)?></b></u></td>
    </tr>
  </table>
</body>