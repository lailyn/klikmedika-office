<!-- <body onload="window.print();"> -->
<?php 
function mata_uang($a){      
  if(is_numeric($a) AND $a != 0 AND $a != ""){
    return number_format($a, 0, ',', '.');
  }else{
    return $a;
  }
}
$order_number = decrypt_url($order_number);
$setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();
$cek_data = $this->db->query("SELECT orders.*, md_konsumen.nama_lengkap FROM orders
  LEFT JOIN md_konsumen ON orders.user_id = md_konsumen.id_konsumen
  WHERE orders.order_number = '$order_number'")->row();
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
  <table border="0" width="80%" align="center">
    <tr>      
      <td colspan="4" align="center">
        <img width="180px" src="assets/im493/<?php echo $setting->logo ?>">
        <p class="text-center">
          <?php echo $setting->alamat ?><br>
          <strong>Telp :</strong> <?php echo $setting->no_telp ?>  
          <strong>Email:</strong> <?php echo $setting->email ?> <br>
          <strong>Website :</strong> <?php echo $setting->url ?>
        </p>
      </td>      
    </tr>
    <tr>
      <td colspan="4"><hr></td>
    </tr>
    <tr>
      <td colspan="4" align="center" valign="middle">
        <h3 style="margin-bottom:0px;"><u>INVOICE</u></h3>        
      </td>
    </tr>
    <tr>
      <td width="20%">No Number</td>
      <td width="30%">: <?php echo $order_number ?></td>
      <td width="20%">Tgl Transaksi</td>
      <td>: <?php echo $cek_data->order_date ?></td>
    </tr>
    <tr>
      <td>Nama Pemesan</td>
      <td>: <?php echo $cek_data->nama_lengkap ?></td>
      <td>Tgl Acara</td>
      <td>: <?php echo $cek_data->tgl_mulai." s/d ".$cek_data->tgl_selesai ?></td>
    </tr>    
    <tr>
      <td colspan="4">
        <table border="1" class="table table-bordered" width="100%">
          <tr>
            <th>Pesanan</th>            
            <th>Qty</th>                        
            <th>Diskon</th>                        
            <th>Harga</th>                        
            <th>Sub Total</th>
          </tr>
          <?php 
          $subs=0; 
          $cek_item = $this->db->query("SELECT products.*, order_items.*, orders.*, orders.total_price FROM order_items LEFT JOIN orders ON order_items.order_id = orders.id
            LEFT JOIN products ON order_items.product_id = products.id
            WHERE orders.order_number = '$order_number'");
          foreach($cek_item->result() AS $tr){  ?>
          <tr>
            <td><?php echo $tr->name ?></td>
            <td><?php echo $tr->order_qty ?></td>
            <td align='right'><?php echo mata_uang_help($tr->diskon) ?></td>
            <td align='right'><?php echo mata_uang_help($tr->order_price) ?></td>
            <td align='right'><?php echo mata_uang_help($sub = $tr->order_price * $tr->order_qty) ?></td>            
          </tr>
          <?php $subs += $sub; } ?> 
          <tr>
            <td align='right' colspan="4">Total</td>
            <td align='right'><?php echo mata_uang($subs) ?></td>            
          </tr>        
        </table> 
        
        <br>
        <table width="100%" border="0">
          <tr>
            <td align='right'><strong>Grand Total</strong></td>
            <td align='right' width="20%"><?php echo mata_uang($subs) ?></td>            
          </tr>
        </table>       
      </td>
    </tr>    
  </table>  
  <br>
  <table width="80%" align="center">      
    <tr>
      <td><i></i></td>   
      <td>Jambi, <?php echo gmdate(" d F Y", time()+60*60*7); ?></td>
    </tr>
    
    <tr>
      <td></td>
      <td>Bag Keuangan <?=$setting->perusahaan ?></td>
    </tr>
    <tr>
      <td></td>
      <td> <br> <br> <br></td>
    </tr>
    <tr>
      <td colspan="2"><br></td>
    </tr>
    <tr>
      <td></td>
      <td>___________________________</td>
    </tr>
  </table>
</body>