<!-- <input type="text" name="isi" value="percobaan"> -->

<table class="table table-bordered">
	<thead>
	  <tr>
	    <th width="5%">No</th>
	    <th>Kode</th>                                           
	    <th>Product</th>	    
	    <th>Qty Onhand</th>              
	    <th>Qty Opname</th>              
	    <th>Qty Selisih</th>    
	    <th>Keterangan</th>          	    
	  </tr>
	</thead>
	<tbody>
		<?php 
		$no=1;
		$tot1=0;
		foreach($dt_products->result() as $key => $row){			
			$jum = $dt_products->num_rows();
			if($row->stok=="Tersedia") $stock = 0;
				else $stock = $row->stok;	

			if(!is_null($row->realStock)) $stock = $row->realStock;		
			echo "
			<tr>
				<td>$no</td>
				<td width='15%'>$row->kode_produk</td>
				<td>$row->nama_produk</td>				
				<td width='10%'><input type='text' name='onhand_$key' id='onhand_$no' value='$stock' class='form-control' readonly></td>
				<td width='10%'>
					<input type='hidden' id='jum' name='jum' value='$jum'>
					<input type='hidden' name='id[$key]' value='$row->id_produk'>					
					<input type='number' onchange='kurang()' id='opname_$no' value='$stock' class='form-control' name='opname_$key'>
				</td>								
				<td width='10%'><input type='number' id='selisih_$no' class='form-control' readonly name='selisih_$key'></td>												
				<td><input type='text' class='form-control' name='keterangan_$key'></td>												
			</tr>";		
			$no++;
			$tot1 += $row->stock;			
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3"><b>Total</b></td>
			<td><input type='number' id='tot_onhand' value="<?php echo $tot1 ?>" class='form-control' readonly name='tot_onhand'></td>			
			<td><input type='number' id='tot_opname' value="<?php echo $tot1 ?>" class='form-control' readonly name='tot_opname'></td>			
			<td><input type='number' id='tot_selisih' class='form-control' readonly name='tot_selisih'></td>						
		</tr>
	</tfoot>
</table>