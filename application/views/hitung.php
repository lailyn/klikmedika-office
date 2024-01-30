<?php 
  
// Mendapatkan jenis web browser pengunjung
function get_client_browser() {
    $browser = '';
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
        $browser = 'Netscape';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
        $browser = 'Firefox';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
        $browser = 'Chrome';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
        $browser = 'Opera';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
        $browser = 'Internet Explorer';
    else
        $browser = 'Other';
    return $browser;
}

$ip    = $this->input->ip_address(); // Mendapatkan IP user
$os    = $_SERVER['HTTP_USER_AGENT'];
$browser  = get_client_browser();//$this->input->ip_address(); // Mendapatkan IP user
$date  = date("Y-m-d"); // Mendapatkan tanggal sekarang
$waktu = time(); //
$timeinsert = date("Y-m-d H:i:s");
  
// Cek berdasarkan IP, apakah user sudah pernah mengakses hari ini
$s = $this->db->query("SELECT * FROM md_visitor WHERE ip='$ip' AND date='$date'")->num_rows();
$ss = isset($s)?($s):0;
if($ss == 0){
	$this->db->query("INSERT INTO md_visitor(ip, os, browser, date, hits, online, time) VALUES('$ip','$os','$browser','$date',1,'$waktu','$timeinsert')");
}else{
	$this->db->query("UPDATE md_visitor SET hits=hits+1, os = '$os', browser = '$browser', online='$waktu' WHERE ip='$ip' AND date='$date'");
}
   
?>