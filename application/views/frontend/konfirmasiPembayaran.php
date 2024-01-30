<div class="container" style="padding-top:140px;margin-bottom: 20px;">
	<?php include 'aside.php'; ?>
	<?php                       
	if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {                    
	?>                  
	<div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable mt-2">
	  <strong><?php echo $_SESSION['pesan'] ?></strong>                    
	</div>
	<?php
	}
	$_SESSION['pesan'] = '';                        

	$cek = $this->db->query("SELECT p.id, p.name FROM orders AS o 
		INNER JOIN order_items AS oi ON o.id = oi.order_id 
    INNER JOIN products AS p ON p.id = oi.product_id          
    WHERE o.id  = '$order->id'");                    
  $layanan = "";        
  foreach($cek->result() AS $dr){
    if($layanan!='') $layanan.=", ";
    $layanan.=$dr->name;
  }
	?>
	
		
	<form action="konfirmasiPost" method="POST" enctype="multipart/form-data" class="row g-3 mt-3">
		<div class="col-md-4">
			<label for="inputCity" class="form-label">Order Number</label>
			<input type="hidden" name="order_id" value="<?=$order->id?>">
			<input type="text" value="<?=$order->order_number?>" name="order_number" readonly class="form-control" id="inputCity">
		</div>      
		<div class="col-md-4">
			<label for="inputCity" class="form-label">Tanggal Pesan</label>
			<input type="text" value="<?=$order->order_date?>" name="email" readonly class="form-control" id="inputCity">
		</div>      
		<div class="col-md-4">
			<label for="inputCity" class="form-label">Layanan</label>
			<input type="text" value="<?=$layanan?>" name="email" readonly class="form-control" id="inputCity">
		</div>      
		
		<div class="col-md-4">
			<label for="inputZip" class="form-label">Nominal</label>
			<input type="number" name="nominal" placeholder="Nominal" value="" required class="form-control" id="inputZip">
		</div>
		<div class="col-md-4">
			<label for="inputZip" class="form-label">Identitas Pengirim</label>
			<input type="text" name="pengirim" placeholder="Identitas Pengirim" value="" required class="form-control" id="inputZip">
		</div>
		<div class="col-md-4">
			<label for="inputZip" class="form-label">Bukti Pengiriman</label>
			<input type="file" name="bukti" required class="form-control" id="inputZip">
		</div>

		<div class="col-12">
			<button class="btn btn-primary" type="submit">Konfirmasi Pembayaran</button>        
			<button class="btn btn-default" type="reset">Reset</button>        
		</div>    
	</form>
	
</div>