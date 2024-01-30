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

	?>
	
	<table class="table table-hovered">
		<thead>
			<?php 
			$no=1;
			$user_id = $this->session->id_konsumen;
			$sql = $this->db->select("o.*,k.nama_lengkap")
        ->join("md_konsumen k","o.user_id=k.id_konsumen","left")        
        ->where("o.user_id",$user_id)
        ->order_by("o.id","desc")
        ->get("orders o");          
      foreach($sql->result() AS $data){
      	if($data->order_status==1){      
          $konfirmasi = "";
          $status = "<label class='badge badge-info'>Booking</label>";
        }elseif($data->order_status==2){      
          $konfirmasi = "display:none;";
          $status = "<label class='badge badge-primary'>Sudah Bayar DP</label>";                    
        }elseif($data->order_status==3){ 
          $konfirmasi = "display:none;";
          $status = "<label class='badge badge-success'>Selesai</label>";
        }elseif($data->order_status==4){ 
          $konfirmasi = "display:none;";
          $status = "<label class='badge badge-danger'>Batal</label>";
        }      	

        if($data->payment_status==1){
        	$konfirmasi = "display:none;";
        	$status = "<label class='badge badge-primary'>Konfirmasi Bayar</label>";
        }

      	$cek = $this->db->query("SELECT p.id, p.name FROM orders AS o 
      		INNER JOIN order_items AS oi ON o.id = oi.order_id 
          INNER JOIN products AS p ON p.id = oi.product_id          
          WHERE o.id  = '$data->id'");                    
        $layanan = "";        
        foreach($cek->result() AS $dr){
          if($layanan!='') $layanan.=", ";
          $layanan.=$dr->name;
        }
      	$catatan = "";
      	if($data->catatan!='') $catatan = "<br> Catatan: ".$data->catatan;

      	$id = encrypt_url($data->id);
			?>
			<tr>
				<th>
					<p>
						Order Number: <?=$data->order_number?> <?=$status?> <br>
						Tanggal Pesan: <?=$data->order_date?> <br>						
						Layanan: <?=$layanan?> <?=$catatan?>
					</p>
				</th>
				<th width="5%">
					<a href="konfirmasi-bayar/<?=$id?>" class="btn btn-danger btn-sm" style="<?=$konfirmasi?>" href="">Konfirmasi Pembayaran</a>
				</th>
			</tr>
			<?php $no++; } ?>
		</thead>
	</table> 
		
	
</div>