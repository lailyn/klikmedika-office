<?php
$d = date('dms'); 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template-produk-".$d.".xls");
header("Pragma: no-cache");
header("Expires: 0");

?>      
<b>
	Catatan : <br>
	1. Sesuaikan field Golongan, Kategori dan Satuan dengan tabel yg tersedia, kemudian Hapus sebelum import.
	2. Setelah selesai, hapus 3 tabel acuan dan Save As dengan format "*.xlsx".
</b>
<table class="table table-hover table-striped" border="1">
	<thead>
	<tr>                
		<th>Kode Produk</th>                            
		<th>Nama Produk</th>		
		<th>Kategori (tabel kategori)</th>
		<th>Tags</th>                
		<th>Satuan (tabel satuan)</th>                		
		<th>Stok (Tersedia/0)</th>                
		<th>Harga</th>                
		<th>Harga Diskon (Harga setelah diskon)</th>                
		<th>Keterangan</th>                
	</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>			
		</tr>                                           
	</tbody>
</table>
<br><br>
<table border="1">    
	<tr>        
		<th>Kategori Produk</th>
	</tr>
	<?php     
	$sql = $this->m_admin->getAll("md_produk_kategori");
	foreach ($sql->result() as $isi) {
		echo "
		<tr>
			<td>$isi->produk_kategori</td>            
		</tr>";        
	}
	?>
</table>
<br>
<br>
<table border="1">    
	<tr>        
		<th>Satuan</th>
	</tr>
	<?php     
	$sql = $this->m_admin->getAll("md_produk_satuan");
	foreach ($sql->result() as $isi) {
		echo "
		<tr>
			<td>$isi->satuan</td>            
		</tr>";        
	}
	?>
</table>
