<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTabelDwigitalProduk extends AbstractMigration
{
  public function change(): void
  {
    $this->table('dwigital_produk')
      ->addColumn('id_produk_kategori', 'integer', ['limit' => 10])
      ->addColumn('kode_produk', 'string', ['limit' => 50])
      ->addColumn('nama_produk', 'string', ['limit' => 100])
      ->addColumn('jenis', 'string', ['limit' => 20])
      ->addColumn('tags', 'string', ['limit' => 100])
      ->addColumn('sat_kecil', 'string', ['limit' => 100])
      ->addColumn('status', 'integer', ['limit' => 2])
      ->addColumn('stok', 'string', ['limit' => 100])
      ->addColumn('gambar', 'string', ['limit' => 200])
      ->addColumn('harga_diskon', 'integer')
      ->addColumn('tipe_diskon', 'string', ['limit' => 100])
      ->addColumn('harga', 'integer')
      ->addColumn('keterangan', 'text')
      ->addColumn('promo', 'integer')
      ->addColumn('harga_beli', 'integer')
      ->addColumn('stock', 'integer')
      ->addColumn('ppnJual', 'integer')
      ->addColumn('margin', 'integer')
      ->addColumn('totalBiaya', 'integer')
      ->addColumn('supplier', 'string', ['limit' => 200])
      ->addColumn('kapasitas', 'string', ['limit' => 200])
      ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
      ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
      ->create();
  }
}
