     <?php
      if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
      ?>
       <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable">
         <strong><?php echo $_SESSION['pesan'] ?></strong>
       </div>
     <?php
      }
      $_SESSION['pesan'] = '';

      ?>

     <?php
      if ($set == "form") {
        $form = "save";
      ?>
       <script>
         Vue.use(VueNumeric.default);
         Vue.filter('toCurrency', function(value) {
           return accounting.formatMoney(value, "", 0, ".", ",");
           return value;
         });
       </script>
       <div class="row" id="form_data">
         <div class="col-12 col-lg-8 grid-margin">
           <div class="card">
             <div class="card-header">
               <div class="row">
                 <div class="col-md-11">
                   <?php if (!isset($row)) { ?>
                     <a href="dwigital/transaksi/penjualan/batal" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Batal dan Kembali</a>
                     <a href="dwigital/transaksi/penjualan/hold" onclick="return confirm('Anda yakin?')" class="btn btn-info btn-sm"><i class="fa fa-check"></i> Tahan dan Buat Baru</a>
                   <?php } else { ?>
                     <a href="dwigital/transaksi/penjualan" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
                   <?php } ?>
                 </div>
                 <div class="col-md-1 text-right" v-if="loading==1">
                   <i class="fa fa-spin fa-spinner mt-1" style="font-size: 15pt;"></i>
                 </div>
               </div>
             </div>
             <div class="card-body">
               <div class="box">
                 <div class="row mb-2">
                   <div class="col-sm-12">
                     <select id="kode_produk" class="form-control" onchange="setProduk(this)"></select>
                   </div>
                 </div>
                 <div class="table-responsive">
                   <table class="table" style="width:100%">
                     <thead>
                       <tr>
                         <th width="2%">No</th>
                         <th width="30%">Produk</th>
                         <th width="15%">Harga</th>
                         <th width="14%" class="text-center">Qty</th>
                         <th width="15%">Diskon (Rp)</th>
                         <th class="text-right">Subtotal</th>
                         <th width="5%"></th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr v-for="(item,index) of list_cart" v-if="list_cart.length>0">
                         <td>{{index+1}}</td>
                         <td>{{item.nama_produk}}</td>
                         <td>
                           <vue-numeric class='form-control form-control-sm text-right' separator='.' v-model='item.harga' @input="setHarga(index)"></vue-numeric>
                         </td>
                         <td>
                           <div class="input-group input-group-sm">
                             <span class="input-group-prepend">
                               <button type="button" class="btn btn-default" @click.prevent="decreaseQty(index)">-</button>
                             </span>
                             <input type="text" class="form-control" v-model="item.qty" @input="setQty(index)">
                             <span class="input-group-append">
                               <button type="button" class="btn btn-default" @click.prevent="increaseQty(index)">+</button>
                             </span>
                           </div>
                         </td>
                         <td>
                           <vue-numeric class='form-control form-control-sm text-right' separator='.' v-model='item.diskon' @input="setDiskon(index)"></vue-numeric>
                         </td>
                         <td class="text-right">{{setSubtotal(index) | toCurrency}}</td>
                         <td>
                           <button type="button" class="btn btn-xs btn-danger" @click="hapusProduk(index)"><i class="fa fa-trash"></i></button>
                         </td>
                       </tr>
                       <tr v-if="list_cart.length==0">
                         <td class="text-center" colspan="7"><em><strong>Silakan Pilih Produk</strong></em></td>
                       </tr>
                     </tbody>
                     <tfoot>
                       <tr>
                         <th colspan="3">Total</th>
                         <th class="text-center">{{totals.qty}}</th>
                         <th class="text-right">{{totals.diskon | toCurrency}}</th>
                         <th class="text-right">{{totals.grand | toCurrency}}</th>
                         <th></th>
                       </tr>
                     </tfoot>
                   </table>
                 </div>
               </div>
             </div>
           </div>
         </div>
         <div class="col-12 col-lg-4 grid-margin">
           <div class="card">
             <div class="card-body">
               <form action='dwigital/transaksi/penjualan/simpanPenjualan' method='POST'>
                 <?php if (isset($row)) { ?>
                   <input type="hidden" name="no_faktur" value="<?= encrypt_url($row->no_faktur) ?>">
                 <?php } ?>
                 <div class="row">
                   <div class="col-12">
                     <div class="form-group row">
                       <label class="col-sm-4 col-form-label-sm">No Faktur</label>
                       <div class="col-sm-4">
                         <input type="text" readonly placeholder="Auto" class="form-control form-control-sm  form-control form-control-sm -sm" value="<?= isset($row) ? $row->no_faktur : '' ?>" />
                       </div>
                       <div class="col-sm-4">
                         <input type="date" name="tgl" placeholder="Tgl" value="<?= date("Y-m-d") ?>" class="form-control form-control-sm  form-control form-control-sm -sm" />
                       </div>
                     </div>
                     <div class="form-group row">
                       <label class="col-sm-4 col-form-label-sm">Customer</label>
                       <div class="col-sm-8">
                         <select class="form-control form-control-sm select2" name="id_user">
                           <option value="">Walk in Customer</option>
                           <?php
                            $dt_user = $this->m_admin->getAll("md_user");
                            foreach ($dt_user->result() as $key => $value) {
                              echo "<option value='$value->id_user'>$value->nama_lengkap</option>";
                            }
                            ?>
                         </select>
                       </div>
                     </div>
                     <div class="form-group row">
                       <label class="col-sm-4 col-form-label-sm">Platform</label>
                       <div class="col-sm-8">
                         <select class="form-control form-control-sm select2" name="id_platform" required>
                           <option value="">Pilih Platform</option>
                           <?php
                            $dt_platform = $this->m_admin->getAll("dwigital_platform");
                            foreach ($dt_platform->result() as $key => $value) {
                              echo "<option value='$value->id'>$value->nama</option>";
                            }
                            ?>
                         </select>
                       </div>
                     </div>
                     <div class="form-group row">
                       <label class="col-sm-4 col-form-label-sm">Catatan</label>
                       <div class="col-sm-8">
                         <textarea class="form-control" name="catatan"><?= isset($row) ? $row->catatan : '' ?></textarea>
                       </div>
                     </div>
                     <div class="form-group row">
                       <label class="col-sm-4 col-form-label-sm">Cara Pembayaran</label>
                       <div class="col-sm-8">
                         <select class="form-control form-control-sm" name="payment_type" required>
                           <option value="cash">Cash</option>
                           <option value="manual_transfer">Manual Transfer</option>
                           <option value="cod">COD</option>
                           <option value="kartu_kredit">Kartu Kredit</option>
                           <option value="bank_transfer">Midtrans</option>
                         </select>
                       </div>
                     </div>
                     <hr>
                     <div class="form-group row">
                       <label class="col-sm-4 col-form-label-sm">
                         <h5 class="mt-1">Nominal</h5>
                       </label>
                       <div class="col-sm-8">
                         <div class="input-group input-group-lg">
                           <input type="text" data-type='currency' autocomplete="off" name="nominal" id="nominal" class="form-control">
                           <span class="input-group-append">
                             <ul class="dropdown-menu">
                               <li onclick="klik(0)" class="dropdown-item"><b>Uang Pas</b></li>
                               <li onclick="klik(5000)" class="dropdown-item">5.000</li>
                               <li onclick="klik(10000)" class="dropdown-item">10.000</li>
                               <li onclick="klik(20000)" class="dropdown-item">20.000</li>
                               <li onclick="klik(50000)" class="dropdown-item">50.000</li>
                               <li onclick="klik(100000)" class="dropdown-item">100.000</li>
                               <li onclick="klik(200000)" class="dropdown-item">200.000</li>
                             </ul>
                             <button type="button" class="btn btn-info dropdown-toggle float-right" data-toggle="dropdown">
                               Pilih
                             </button>
                           </span>
                         </div>
                       </div>
                     </div>
                     <div class="form-group row">
                       <label class="col-sm-4 col-form-label-sm">
                         <h5 class="mt-1">Kembalian</h5>
                       </label>
                       <div class="col-sm-8">
                         <div class="input-group input-group-lg">
                           <input readonly style="font-size:30px;" id="kembalian" type="text" data-type="currency" name="kembalian" autocomplete="off" class="form-control form-control-lg">
                           <span class="input-group-append">
                             <button onclick="bersihkan()" type="button" class="btn btn-danger btn-flat">Reset</button>
                           </span>
                         </div>
                       </div>
                     </div>
                     <div class="form-group row">
                       <div class="col-sm-4"></div>
                       <div class="col-sm-8">
                         <div class="custom-control custom-checkbox">
                           <input class="custom-control-input" type="checkbox" name="cetakStruk" checked value="1" id="cetakStruk">
                           <label for="cetakStruk" class="custom-control-label">Cetak Struk</label>
                         </div>
                       </div>
                     </div>
                     <div class="form-group row">
                       <label class="col-sm-4 col-form-label-sm"></label>
                       <div class="col-sm-8">
                         <button id="tombolSimpan" onclick="return confirm('Pastikan semua data sudah benar! Lanjutkan?')" class="btn btn-success" type="submit"> <i class="fa fa-save"></i> Selesaikan Transaksi</button>
                       </div>
                     </div>
                   </div>
                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>
       </div>
       <script src="assets/backend/plugins/jquery/jquery.min.js"></script>
       <?php
        $this->load->view('reference/selectProdukReady');
        ?>
       <script>
         var no_faktur = "<?= isset($id) ? encrypt_url($id) : '' ?>";
         var form_data = new Vue({
           el: '#form_data',
           data: {
             loading: 0,
             list_cart: <?= isset($list_cart) ? json_encode($list_cart) : '[]' ?>
           },
           methods: {
             setSubtotal: function(index) {
               var item = this.list_cart[index];
               var subtotal = item.harga * item.qty - item.diskon;
               return subtotal;
             },
             hapusProduk: function(index) {
               var item = this.list_cart[index];
               $.ajax({
                 beforeSend: function() {
                   form_data.loading = 1;
                 },
                 url: "<?= base_url("$page/updateCart") ?>",
                 type: "POST",
                 dataType: 'JSON',
                 data: {
                   id: item.id_produk,
                   hapus: 1,
                   no_faktur: no_faktur
                 },
                 success: function(response) {
                   form_data.loading = 0;
                   form_data.list_cart = response.data;
                 }
               });
             },
             decreaseQty: function(index) {
               var item = this.list_cart[index];
               qty = parseInt(item.qty) - 1;
               $.ajax({
                 beforeSend: function() {
                   form_data.loading = 1;
                 },
                 url: "<?= base_url("$page/updateCart") ?>",
                 type: "POST",
                 dataType: 'JSON',
                 data: {
                   id: item.id_produk,
                   qty: qty,
                   no_faktur: no_faktur
                 },
                 success: function(response) {
                   form_data.loading = 0;
                   form_data.list_cart = response.data;
                 }
               });
             },
             increaseQty: function(index) {
               var item = this.list_cart[index];
               qty = parseInt(item.qty) + 1;
               $.ajax({
                 beforeSend: function() {
                   form_data.loading = 1;
                 },
                 url: "<?= base_url("$page/updateCart") ?>",
                 type: "POST",
                 dataType: 'JSON',
                 data: {
                   id: item.id_produk,
                   qty: qty,
                   no_faktur: no_faktur
                 },
                 success: function(response) {
                   form_data.loading = 0;
                   form_data.list_cart = response.data;
                   if (response.status == 0) {
                     toastDanger(response.message);
                   }
                 }
               });
             },
             setHarga: function(index) {
               var item = this.list_cart[index];
               $.ajax({
                 beforeSend: function() {
                   form_data.loading = 1;
                 },
                 url: "<?= base_url("$page/updateCart") ?>",
                 type: "POST",
                 dataType: 'JSON',
                 data: {
                   id: item.id_produk,
                   harga: item.harga,
                   no_faktur: no_faktur
                 },
                 success: function(response) {
                   form_data.loading = 0;
                   form_data.list_cart = response.data;
                   if (response.status == 0) {
                     toastDanger(response.message);
                   }
                 }
               });
             },
             setQty: function(index) {
               var item = this.list_cart[index];
               qty = parseInt(item.qty);
               $.ajax({
                 beforeSend: function() {
                   form_data.loading = 1;
                 },
                 url: "<?= base_url("$page/updateCart") ?>",
                 type: "POST",
                 dataType: 'JSON',
                 data: {
                   id: item.id_produk,
                   qty: qty,
                   no_faktur: no_faktur
                 },
                 success: function(response) {
                   form_data.loading = 0;
                   form_data.list_cart = response.data;
                   if (response.status == 0) {
                     toastDanger(response.message);
                   }
                 }
               });
             },
             setDiskon: function(index) {
               var item = this.list_cart[index];
               diskon = parseInt(item.diskon);
               $.ajax({
                 beforeSend: function() {
                   form_data.loading = 1;
                 },
                 url: "<?= base_url("$page/updateCart") ?>",
                 type: "POST",
                 dataType: 'JSON',
                 data: {
                   id: item.id_produk,
                   diskon: diskon,
                   no_faktur: no_faktur
                 },
                 success: function(response) {
                   form_data.loading = 0;
                   form_data.list_cart = response.data;
                   if (response.status == 0) {
                     toastDanger(response.message);
                   }
                 }
               });
             },
           },
           computed: {
             totals: function() {
               var grand = 0;
               var qty = 0;
               var diskon = 0;
               index = 0;
               for (item of this.list_cart) {
                 grand += this.setSubtotal(index);
                 qty += parseInt(item.qty);
                 diskon += parseInt(item.diskon);
                 index++;
               }
               return {
                 grand: grand,
                 qty: qty,
                 diskon: diskon,
               }
             },
           }
         })

         function setProduk() {
           var data = $("#kode_produk").select2('data')[0];
           if (data != undefined) {
             $.ajax({
               beforeSend: function() {
                 form_data.loading = 1;
               },
               url: "<?= base_url("$page/insertCart") ?>",
               type: "POST",
               dataType: 'JSON',
               data: {
                 id: data.id,
                 no_faktur: no_faktur
               },
               success: function(response) {
                 form_data.loading = 0;
                 $("#kode_produk").val(null).trigger('change');
                 if (response.status == 1) {
                   form_data.list_cart = response.data;
                   console.log(form_data);
                 } else {
                   toastDanger(response.message);
                 }
               }
             });
           }
         }
       </script>
       <script type="text/javascript">
         window.onload = function() {
           document.getElementById("tombolSimpan").disabled = true;
         };
         document.getElementById("nominal").addEventListener("input", function(event) {
           let nominal = $("#nominal").val();
           let nominal_asli = nominal.replace(",", "");
           let total = form_data.totals.grand;
           console.log(total);
           let hasil = nominal_asli - total;
           let hasil_rp = formatRupiah(hasil);
           if (hasil < 0) hasil_rp = "-" + hasil_rp;
           $("#kembalian").val(hasil_rp);
           if (hasil >= 0) {
             document.getElementById("tombolSimpan").disabled = false;
           } else {
             document.getElementById("tombolSimpan").disabled = true;
           }
         });

         function bersihkan() {
           $("#nominal").val('');
           $("#kembalian").val('');
           document.getElementById("tombolSimpan").disabled = true;
         }

         function hitung() {
           let nominal = $("#nominal").val();
           let nominal_asli = nominal.replace(".", "");
           let total = form_data.totals.grand;
           let hasil = nominal_asli - total;
           let hasil_rp = formatRupiah(hasil);
           if (hasil < 0) hasil_rp = "-" + hasil_rp;
           $("#kembalian").val(hasil_rp);
           if (hasil >= 0) {
             document.getElementById("tombolSimpan").disabled = false;
           } else {
             document.getElementById("tombolSimpan").disabled = true;
           }
         }

         function klik(angka) {
           let angka_asli = parseInt(angka);
           if (angka_asli == 0) {
             angka_asli = form_data.totals.grand;
           }
           let nominal = $("#nominal").val();
           let nominal_asli = nominal.replace(".", "");
           if (nominal_asli != '') {
             angka_asli = parseInt(nominal_asli) + parseInt(angka_asli);
           }
           let nominal_rp = formatRupiah(angka_asli);
           $("#nominal").val(nominal_rp);
           hitung();
         }
       </script>
     <?php
      } elseif ($set == "detail") {
        $row = $dt_penjualan->row();
        if ($set == "detail") {
          $read = "readonly";
          $read2 = "disabled";
          $vis  = "style='display:none;'";
        } else {
          $read = "";
          $read2 = "";
          $vis = "";
        }

        if ($row->id_user != 0) {
          $cek_user = $this->m_admin->getByID("md_user", "id_user", $row->id_user);
          $customer = ($cek_user->num_rows() > 0) ? $cek_user->row()->nama_lengkap : "";
        } else {
          $customer = "Walk in Customer";
        }
      ?>

       <div class="row">
         <div class="col-12 grid-margin">
           <div class="card">
             <div class="card-header">
               <h4 class="card-title"><a href="dwigital/transaksi/penjualan<?= isset($_GET['riwayat']) ? '/riwayat' : '' ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
             </div>
             <div class="card-body">
               <form action="dwigital/transaksi/penjualan/save_status" method="POST" enctype="multipart/form-data" class="form-sample">
                 <div class="row">
                   <div class="col-12">
                     <div class="form-group row">
                       <label class="col-sm-2 col-form-label-sm">No Faktur</label>
                       <div class="col-sm-2">
                         <input type="hidden" name="id_cart" value="<?php echo $id ?>">
                         <input type="text" readonly value="<?php echo $tampil = ($row != '') ? $row->no_faktur : ""; ?>" name="no_faktur" placeholder="No Faktur" class="form-control form-control-sm  form-control form-control-sm -sm" />
                       </div>
                       <label class="col-sm-1 col-form-label-sm">Tgl Pesanan</label>
                       <div class="col-sm-2">
                         <input type="text" readonly value="<?php echo $tampil = ($row != '') ? $row->tgl : ""; ?>" name="username" placeholder="Tgl Order" class="form-control form-control-sm  form-control form-control-sm -sm" />
                       </div>
                       <label class="col-sm-1 col-form-label-sm">Nama User</label>
                       <div class="col-sm-2">
                         <input type="text" readonly value="<?php echo $tampil = ($row != '') ? $customer : ""; ?>" name="username" placeholder="Nama User" class="form-control form-control-sm  form-control form-control-sm -sm" />
                       </div>
                     </div>

                     <div class="form-group row">
                       <label class="col-sm-2 col-form-label-sm">Catatan</label>
                       <div class="col-sm-10">
                         <textarea class="form-control form-control-sm  form-control form-control-sm -sm" readonly><?php echo $row->catatan ?></textarea>
                       </div>
                     </div>
                     <hr>

                     <div class="form-group row">
                       <label class="col-sm-2 col-form-label-sm"></label>
                       <div class="col-sm-10">
                         <div class="box">
                           <label>
                             <h5>Rincian Pesanan</h5>
                           </label>
                           <div class="table-responsive">
                             <table id="example2" class="table table-striped" style="width:100%">
                               <thead>
                                 <tr>
                                   <th>Nama Produk</th>
                                   <th>Harga</th>
                                   <th>Qty</th>
                                   <th width="10%">Diskon</th>
                                   <th width="10%">Sub Total</th>
                                 </tr>
                               </thead>
                               <tbody>
                                 <?php
                                  $t_qty = 0;
                                  $t_subtotal = 0;
                                  $t_diskon = 0;
                                  $sql = $this->db->query("SELECT * FROM dwigital_cart_detail WHERE no_faktur = '$row->no_faktur'");
                                  foreach ($sql->result() as $isi) {
                                    if (!isset($isi->gambar) or $isi->gambar == "") {
                                      $gambar = "produk.png";
                                    } else {
                                      $gambar = $isi->gambar;
                                    }
                                    echo "
                                <tr>                                  
                                  <td>$isi->nama_produk</td>
                                  <td>" . mata_uang($isi->harga) . "</td>                                  
                                  <td>$isi->qty $isi->satuan</td>    
                                  <td align='right'>" . mata_uang($isi->diskon) . "</td>                              
                                  <td align='right'>" . mata_uang($subtotal = $isi->qty * $isi->harga - $isi->diskon) . "</td>                                  
                                </tr>
                                ";
                                    $t_qty += $isi->qty;
                                    $t_subtotal += $subtotal;
                                    $t_diskon += $isi->diskon;
                                  }
                                  ?>

                                 <tr>
                                   <td colspan="2">
                                     <h3>Grand Total</h3>
                                   </td>
                                   <td style="font-size: 13pt;"><strong><?php echo $t_qty ?> item</strong></td>
                                   <td style="font-size: 13pt;" align='right'><strong><?php echo mata_uang($t_diskon) ?></strong></td>
                                   <td style="font-size: 13pt;" align='right'><strong><?php echo mata_uang($t_subtotal) ?></strong></td>
                                 </tr>
                                 <tr>
                                   <th colspan="4">Nominal Bayar</th>
                                   <td align='right'><?php echo mata_uang($row->nominal) ?></td>
                                 </tr>
                                 <tr>
                                   <th colspan="4">Kembalian</th>
                                   <td align='right'><?php echo mata_uang($row->kembalian) ?></td>
                                 </tr>
                               </tbody>
                             </table>
                           </div>
                         </div>
                       </div>
                     </div>



                   </div>
                 </div>
                 <div class="row">
                   <div class="col-12">
                     <hr>
                     <div class="row">
                       <div <?php echo $vis ?> class="col-md-6">
                         <button type="submit" name="submit" value="dikirim" onclick="return confirm('Anda yakin?')" class="btn btn-primary">Set Dikirim</button>
                         <button type="submit" name="submit" value="selesai" onclick="return confirm('Anda yakin?')" class="btn btn-gradient-success mr-2">Set Selesai</button>
                         <button type="submit" name="submit" value="batal" onclick="return confirm('Anda yakin?')" class="btn btn-gradient-danger mr-2">Set Batal</button>
                         <button type="reset" class="btn btn-light">Reset</button>
                       </div>
                     </div>
                   </div>
                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>
       </div>


     <?php } elseif ($set == "view") { ?>


       <div class="row">
         <div class="col-12 grid-margin">
           <div class="card">
             <div class="card-header">
               <h4 class="card-title">
                 <a href="dwigital/transaksi/penjualan/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Transaksi Baru</a>
                 <a href="dwigital/transaksi/penjualan/riwayat" class="btn btn-warning btn-sm"><i class="mdi mdi-history"></i> Riwayat</a>
               </h4>
             </div>
             <div class="card-body">
               <div class="box">
                 <div class="table-responsive">
                   <table id="example" class="table table-striped" style="width:100%">
                     <thead>
                       <tr>
                         <th width="5%">No</th>
                         <th width="10%"></th>
                         <th>No Faktur</th>
                         <th>Tanggal</th>
                         <th>Customer</th>
                         <th>Platform</th>
                         <th>Total</th>
                         <th>Status</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php
                        $no = 1;
                        foreach ($dt_penjualan->result() as $isi) {

                          if ($isi->id_user != 0) {
                            $cek_user = $this->m_admin->getByID("md_pasien", "id_pasien", $isi->id_user);
                            $customer = ($cek_user->num_rows() > 0) ? $cek_user->row()->nama_lengkap : "";
                          } else {
                            $customer = "Walk in Customer";
                          }

                          $platform = $this->db->where("id", $isi->id_platform)->get("dwigital_platform")->row()->nama ?? '';

                          $pembayaran = "d-none";
                          $hapus = "d-none";
                          $edit = "d-none";
                          if ($isi->status == "baru") {
                            $status = "<label class='badge badge-info'>Baru</label>";
                          } elseif ($isi->status == "hold") {
                            $edit = "";
                            $hapus = "";
                            $status = "<label class='badge badge-warning'>Hold</label>";
                          } elseif ($isi->status == "selesai") {
                            $status = "<label class='badge badge-success'>Selesai</label>";
                          } elseif ($isi->status == "batal") {
                            $status = "<label class='badge badge-danger'>Batal</label>";
                          }

                          if ($isi->status_bayar == 0) {
                            $status_bayar = "<label class='badge badge-info'>Input</label>";
                          } elseif ($isi->status_bayar == 1) {
                            $status_bayar  = "<label class='badge badge-warning'>Waiting</label>";
                          } elseif ($isi->status_bayar == 2) {
                            $status_bayar  = "<label class='badge badge-success'>Confirmed</label>";
                          } elseif ($isi->status_bayar == 3) {
                            $status_bayar  = "<label class='badge badge-danger'>Canceled</label>";
                          }

                          if ($isi->status == "baru" || $isi->status == "hold") $er = "";
                          else $er = "style='display:none;'";

                          $cekTotal = $this->db->query("SELECT SUM(harga*qty) AS tot FROM dwigital_cart_detail WHERE no_faktur = '$isi->no_faktur'")->row()->tot;

                          $id = encrypt_url($isi->no_faktur);
                          $link = "dwigital/transaksi/penjualan/detail/$id";

                          echo "
                    <tr>
                      <td>$no</td>
                      <td>
                        <div $er class='btn-group'>
                          <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
                          <div class='dropdown-menu'>
                            <a onclick=\"return confirm('Anda yakin?')\" href='dwigital/transaksi/penjualan/delete/$id' class='dropdown-item $hapus'>Hapus</a>                            
                            <a href='dwigital/transaksi/penjualan/edit/$id' class='dropdown-item $edit'>Edit</a>
                            <a href='dwigital/transaksi/penjualan/pembayaran/$id' class='dropdown-item $pembayaran'>Pembayaran</a>                                                        
                          </div>
                        </div>  
                      </td>
                      <td><a href='$link'>$isi->no_faktur</a></td>
                      <td>$isi->tgl</td>                                          
                      <td>$customer</td>                                          
                      <td>$platform</td>                                          
                      <td align='left'>" . mata_uang_help($cekTotal) . "</td>                      
                      <td>
                        Bayar: $status_bayar
                        <br>Pesanan: $status
                      </td>                      
                    </tr>
                    ";
                          $no++;
                        }
                        ?>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
       </div>

     <?php } elseif ($set == "riwayat") { ?>


       <div class="row">
         <div class="col-12 grid-margin">
           <div class="card">
             <div class="card-header">
               <h4 class="card-title"><a href="dwigital/transaksi/penjualan" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a></h4>
             </div>
             <div class="card-body">
               <div class="box">
                 <div class="table-responsive">
                   <table id="serverside-tables" class="table table-striped" style="width:100%">
                     <thead>
                       <tr>
                         <th width="5%">No</th>
                         <th>No Faktur</th>
                         <th>Tanggal</th>
                         <th>Customer</th>
                         <th>Platform</th>
                         <th>Total</th>
                         <th width="5%">#</th>
                       </tr>
                     </thead>
                   </table>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
       </div>
       <script src="assets/backend/plugins/jquery/jquery.min.js"></script>
       <script>
         $(document).ready(function() {
           $('#serverside-tables').DataTable({
             processing: true,
             serverSide: true,
             language: {
               "infoFiltered": "",
               "processing": "<p style='font-size:20pt;background:#d9d9d9b8;color:black;width:100%'><i class='fa fa-spinner fa-spin'></i></p>",
             },
             order: [],
             ajax: {
               url: "<?= base_url($page . '/fetchRiwayat') ?>",
               dataSrc: "data",
               data: function(d) {
                 // d.nama = $('#nama_m').val();
                 // return d;
               },
               type: "POST"
             },
             "columnDefs": [{
                 "targets": [0, 5],
                 "orderable": false
               },
               {
                 "targets": [0, 5],
                 "className": 'text-center'
               },
             ]
           });
         });
       </script>
     <?php } elseif ($set == 'insert' and $mode == 'import') {
      ?>

       <div class="row">
         <div class="col-12 grid-margin">
           <div class="card">
             <div class="card-header">
               <h4 class="card-title">
                 <a href="dwigital/produk/produk" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
               </h4>
             </div>
             <div class="card-body">
               <form action="dwigital/transaksi/penjualan/importExcel" method="POST" enctype="multipart/form-data" class="form-sample">
                 <div class="row">
                   <div class="col-12">
                     <div class="form-group row">
                       <label class="col-sm-2 col-form-label-sm">Upload</label>
                       <div class="col-sm-8">
                         <input type="file" name="file" class="form-control form-control-sm" />
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="col-12">
                     <hr>
                     <div class="row">
                       <div class="col-md-6">
                         <button type="submit" class="btn btn-primary">Save</button>
                       </div>
                     </div>
                   </div>
                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>


     <?php } ?>