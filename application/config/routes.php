<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'M4suk4dm1n';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['detail/(:any)'] = 'home/blogDetail/$1';
$route['cari/(:any)'] = 'home/cari/$1';
$route['register'] = 'home/register';
$route['registerPost'] = 'home/registerPost';
$route['profilPost'] = 'home/profilPost';
$route['loginPost'] = 'home/loginPost';
$route['login'] = 'home/login';
$route['profil'] = 'home/profil';
$route['galeri'] = 'home/galeri';
$route['pesan'] = 'home/pesan';
$route['blog'] = 'home/blog';
$route['blog/pages/(:any)'] = 'home/blog/$1';
$route['kontak'] = 'home/kontak';
$route['kalender'] = 'home/kalender';
$route['cara-pemesanan'] = 'home/caraPemesanan';
$route['paket-penyewaan'] = 'home/paketPenyewaan';

$route['pesan/(:any)'] = 'customer/saveProduk/$1';
$route['konfirmasi-bayar/(:any)'] = 'customer/konfirmasiPembayaran/$1';
$route['customer'] = 'customer/index';
$route['riwayat-transaksi'] = 'customer/riwayatTransaksi';
$route['konfirmasiPost'] = 'customer/konfirmasiPost';
$route['keranjang-pesan'] = 'customer/keranjangPesan';
$route['simpanPenyewaan'] = 'customer/simpanPenyewaan';


$route['dwigital/transaksi/withdraw']                 = 'dwigital/transaksi/Withdraw/index';
$route['dwigital/transaksi/withdraw/edit/(:any)']     = 'dwigital/transaksi/Withdraw/edit/$1';
$route['dwigital/transaksi/withdraw/store']           = 'dwigital/transaksi/Withdraw/store';
$route['dwigital/transaksi/withdraw/update/(:any)']   = 'dwigital/transaksi/Withdraw/update/$1';
$route['dwigital/transaksi/withdraw/delete/(:any)']   = 'dwigital/transaksi/Withdraw/delete/$1';
$route['dwigital/transaksi/withdraw/destroy/(:any)']  = 'dwigital/transaksi/Withdraw/destroy/$1';


 

$route['admin'] = 'admin/admin';
