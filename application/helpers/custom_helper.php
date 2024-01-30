<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
 * Custom Helpers
 *
 */
//encrypt
if (!function_exists('post_method')) {
    function encr()
    {
        return "";
    }
}
function pref()
{
    return "62";
}
function slugAdmin()
{
    return "m4suk4dm1n";
}
function tgl_indo($tanggal){
    $bulan = array (
      1 =>   'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    
    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun
   
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
  }
function manipulate_time($tgl,$jenis,$lama,$op,$format=null){    
    if(is_null($format)){
        $tgl_baru = date("Y-m-d h:i:s", strtotime("".$op.$lama." ".$jenis."", strtotime($tgl)));
    }else{
        $tgl_baru = date($format, strtotime("".$op.$lama." ".$jenis."", strtotime($tgl)));
    }
    return $tgl_baru;
}
function waktu(){
    return gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);     
}
function jam(){
    return gmdate("H:i:s", time() + 60 * 60 * 7);       
}
function tgl(){
    return gmdate("Y-m-d", time() + 60 * 60 * 7);       
}   
function hitung_umur($tanggal_lahir){
    $birthDate = new DateTime($tanggal_lahir);
    $today = new DateTime("today");
    if ($birthDate > $today) { 
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    return $y;
}
function mata_uang_help($a){      
    if(is_numeric($a) AND $a != 0 AND $a != ""){
      return number_format($a, 0, ',', '.');
    }else{
      return $a;
    }
}
function setMenu($id){
    $ci =& get_instance();
    return $ci->m_admin->user_menu($id);
}
function datatableFilter($table, $columns_search = [], $columns_order = [], $tables_join = [], $custom_select = null, $custom_where = [], $limit = false, $nolimit = false){
  $ci =& get_instance();

  if($custom_select) $ci->db->select($custom_select);

  foreach ($tables_join as $table_join) {
    if(is_array($table_join)){
      if(array_key_exists(0, $table_join)){
        $parent = reset($table_join);
        $table_join = key($table_join);

        $ci->db->join($table_join, "{$table_join}.id_{$parent} = {$parent}.id");
      } else {
        $parent = reset($table_join);
        $table_join = key($table_join);

        $ci->db->join($table_join, "{$parent}.id_{$table_join} = {$table_join}.id");
      }
    }
    else $ci->db->join($table_join, "{$table}.id_{$table_join} = {$table_join}.id");
  }

  foreach ($custom_where as $where) {
    if(is_array($where)){
      $key = reset($where);
      $value = key($where);
      $ci->db->where($value, $key);
    } else $ci->db->where($where);
  }

  $i = 0;
  foreach ($columns_search as $item) {
    if($_POST['search']['value']) {
        if($i===0){
            $ci->db->group_start();
            $ci->db->like($item, $_POST['search']['value']);
        } else $ci->db->or_like($item, $_POST['search']['value']);

        if(count($columns_search) - 1 == $i) $ci->db->group_end();
    }
    $i++;
  }

  if(isset($_POST['order'])) {
      if(!empty($columns_order) && !empty($columns_order[$_POST['order']['0']['column']])) $ci->db->order_by($columns_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
  }

  if(!$nolimit) if($_POST['length'] != -1) $ci->db->limit($_POST['length'], $_POST['start']);  
  if($limit) $ci->db->limit($limit);
  return $ci->db->get($table)->result();
}
?>