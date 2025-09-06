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

$route['admin'] = 'admin/admin';

$route['transaksi/pengajuan_cuti'] = 'transaksi/pengajuan_cuti/index';
$route['transaksi/pengajuan_cuti/riwayat'] = 'transaksi/pengajuan_cuti/riwayat';
$route['transaksi/pengajuan_cuti/set_status/(:num)/(:any)'] = 'transaksi/pengajuan_cuti/set_status/$1/$2';
