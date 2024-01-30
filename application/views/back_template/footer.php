  </div>
  </section>
  </div>
  <?php 
  $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();
  $y = date("Y");
  if($y=='2021') $year = $y;
    else $year = '2021 - '.$y;
  ?>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo $year ?> <a><?php echo $setting->perusahaan ?></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 0.1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<script src="assets/backend/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="assets/backend/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>  
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="assets/backend/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="assets/backend/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="assets/backend/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="assets/backend/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="assets/backend/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="assets/backend/plugins/moment/moment.min.js"></script>
<script src="assets/backend/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="assets/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="assets/backend/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/backend/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="assets/backend/dist/js/pages/dashboard3.js"></script> -->
<script src="assets/backend/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/backend/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/backend/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/backend/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="assets/backend/plugins/select2/js/select2.full.min.js"></script>
<script>
  $('.select2').select2();

  $(function () {    
    $('#summernote').summernote()
    $('#summernote1').summernote()
  });
  $(function () {
    // Summernote
    $('#summernote2').summernote()
  });
</script>
<script>
  $(function () {    
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
    $("input[data-type='currency']").on({
        keyup: function() {
          formatCurrency($(this));
        },
        blur: function() { 
          formatCurrency($(this), "blur");
        }
    });


    function formatNumber(n) {
      // format number 1000000 to 1,234,567
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
      // appends $ to value, validates decimal side
      // and puts cursor back in right position.
      
      // get input value
      var input_val = input.val();
      
      // don't validate empty input
      if (input_val === "") { return; }
      
      // original length
      var original_len = input_val.length;

      // initial caret position 
      var caret_pos = input.prop("selectionStart");
        
      // check for decimal
      if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);
        
        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
          right_side += "00";
        }
        
        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = left_side + "." + right_side;

      } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = input_val;
        
        // final formatting
        
      }
      
      // send updated string to input
      input.val(input_val);

      // put caret back in the right position
      var updated_len = input_val.length;
      caret_pos = updated_len - original_len + caret_pos;
      input[0].setSelectionRange(caret_pos, caret_pos);
    }
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
      $("#example").DataTable();  
      $("#example_lagi").DataTable();  
      $(document).ready(function() {
        $('#example2_old').DataTable( {
          "paging":   false,
          "ordering": false,
          "info":     false,
          "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
            "sEmptyTable": "Tidak ada data di database"
            }
        } );
      } );
      $(document).ready(function() {
        $('#example3').DataTable( {
          "paging":   false,
          "ordering": false,
          "info":     false,
          "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
            "sEmptyTable": "Tidak ada data di database"
            }
        } );
      } );
      $(document).ready(function() {
        $('#example4').DataTable( {
          "paging":   false,
          "ordering": false,
          "info":     false,
          "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
            "sEmptyTable": "Tidak ada data di database"
            }
        } );
      } );
      $("#kelurahan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/kelurahan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#kecamatan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/kecamatan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#jenis_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/jenis/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#kabupaten_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/kabupaten/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#provinsi_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/provinsi/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#dokter_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/dokter/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#karyawan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/karyawan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#konsumen_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("transaksi/konsumen/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#supplier_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/supplier/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#pasien_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("klinik/pasien/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#pendaftaran_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("klinik/pendaftaran/ajax_list")?>",
            type: "POST"
        }
      } );

      var currentLocation = window.location;
      var arrString = currentLocation.toString().split("/");      
      var noReg = arrString[arrString.length - 1];           
      $("#icd_dt").DataTable( {        
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("klinik/pendaftaran/ajax_icd")?>",
            data:{"noReg":noReg},
            type: "POST"
        }
      } );
      $("#resepK_dt").DataTable( {        
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("klinik/pendaftaran/ajax_resepK")?>",
            data:{"noReg":noReg},
            type: "POST"
        }
      } );
      $("#jual_dt").DataTable( {        
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("transaksi/po/ajax_resepK")?>",
            data:{"noReg":noReg},
            type: "POST"
        }
      } );
      $("#jualan_dt").DataTable( {        
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("transaksi/penyewaan/ajax_resepK")?>",
            data:{"noReg":noReg},
            type: "POST"
        }
      } );
      $("#layananKliniks_dt").DataTable( {        
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("klinik/pendaftaran/ajax_layananK")?>",
            data:{"noReg":noReg},
            type: "POST"
        }
      } );
      $("#lamaran_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/lamaran/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#instansi_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/instansi/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#penyakit_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/penyakit/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#semua").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/produk/ajax_list")?>",
            type: "POST"
        }
      } );      
      $("#obat").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/produk/ajax_list/obat")?>",
            type: "POST"
        }
      } );    
      $("#alkes").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/produk/ajax_list/alkes")?>",
            type: "POST"
        }
      } );        
      $("#user_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/user/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#ongkir_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/ongkir/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#artikel_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/artikel/ajaxRequest")?>",
            type: "POST"
        }
      } );
      $("#dokumen_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/dokumen/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#kerjasama_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/kerjasama/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#slide_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/slide/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#galeri_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/galeri/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#faq_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/faq/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#profil_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/profil/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#promo_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/promo/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#pesan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/pesan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#layananKlinik_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("klinik/layananKlinik/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#layanan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("trans/layanan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#layanan_sub_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("trans/layanan_sub/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#layanan_sub2_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("trans/layanan_sub2/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#layanan_sub3_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("trans/layanan_sub3/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#order_dt").DataTable( {
        serverSide: true,              
        ajax: {
            url: "<?php echo site_url("trans/order/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#payout_dt").DataTable( {
        serverSide: true,              
        ajax: {
            url: "<?php echo site_url("trans/payout/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#saldo_dt").DataTable( {
        serverSide: true,              
        ajax: {
            url: "<?php echo site_url("trans/saldo/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#konsultasi_dt").DataTable( {
        serverSide: true,              
        ajax: {
            url: "<?php echo site_url("trans/konsultasi/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#promosi_dt").DataTable( {
        serverSide: true,              
        ajax: {
            url: "<?php echo site_url("master/promosi/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#antrean_dt").DataTable( {
        serverSide: true,              
        ajax: {
            url: "<?php echo site_url("trans/antrean/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#tamu_dt").DataTable( {
        serverSide: true,              
        ajax: {
            url: "<?php echo site_url("master/tamu/ajax_list")?>",
            type: "POST"
        }
      } );

    });
    </script>
    
    <script src="assets/masking/jquery.mask.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          $('.date').mask('00/00/0000');
          $('.time').mask('00:00:00');
          $('.date_time').mask('00/00/0000 00:00:00');
          $('.phone').mask('0000-0000');
          $('.phone_with_ddd').mask('(00) 0000-0000');
          $('.phone_us').mask('(000) 000-0000');
          $('.mixed').mask('AAA 000-S0S');
          $('.money').mask('000.000.000.000.000,00', {reverse: true});
          $('.money2').mask("#.##0,00", {reverse: true});
          $('.ip_address').mask('099.099.099.099');
          $('.percent').mask('##0,00%', {reverse: true});
          $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
          $('.credit_card').mask('0000 0000 0000 0000');
          $('.valid').mask('00/00');
        });
      </script>
</body>
</html>
