



 <div class="iq-breadcrumb">
       <div class="container-fluid">
          <div class="row align-items-center">
             <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <h2 class="subtitle iq-fw-6 text-white mb-3">Kalender Puri Gracia</h2>
             </div>               
          </div>
       </div>
    </div>
    <div class="main-content">      
      <div class="card" style="margin:10px;">
        <div class="card-header">Anda bisa melihat Kalender Puri Gracia untuk menentukan Hari dan Tanggal yang Tersedia / belum di-booking oleh orang lain. </div>
        <div class="card-body">
          <div id="calendar"></div>
        </div>
      </div>
    </div>

    <center>        
        <div class="col-lg-6 col-sm-12 mb-4">            
            <p class="mt-3 mb-4">
              Sudah tentukan tanggal acaranya? <a href='pesan' class="btn btn-sm btn-warning"> Pesan Sekarang! </a>              
            </p>                      
        </div>
      </center>
  </div>

<script src="https://unpkg.com/rc-year-calendar@latest/dist/rc-year-calendar.umd.min.js"></script>

<script type="text/javascript">
const currentYear = 2023;

const calendar = new Calendar('#calendar', {
    style:'background',
    dataSource: [
      <?php          
      $sql   = "SELECT tgl_mulai, tgl_selesai FROM orders              
        WHERE order_status <> 4";
      
      $cek = $this->db->query($sql);
      foreach ($cek->result() as $r) {          
        $year_mulai=substr($r->tgl_mulai, 0, 4);
        $year_selesai=substr($r->tgl_selesai, 0, 4);
        $bln_mulai=substr($r->tgl_mulai, 5, 2) - 1;        
        $bln_selesai=substr($r->tgl_selesai, 5 , 2) - 1;        
        $tgl_mulai=substr($r->tgl_mulai, 8, 2);        
        $tgl_selesai=substr($r->tgl_selesai, 8, 2);        
        ?>        
        {
          
          startDate: new Date('<?=$year_mulai?>', '<?=$bln_mulai?>', '<?=$tgl_mulai?>'),
          endDate: new Date('<?=$year_selesai?>', '<?=$bln_selesai?>', '<?=$tgl_selesai?>'),
          
        },
      <?php } ?>
    ]
});


</script>