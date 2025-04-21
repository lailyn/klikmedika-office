<style type="text/css">
  #tengah{
    display: block;
    margin: 0 auto; /* Tengahkan secara horizontal */
  }
  #signatureCanvas1{    
    border: 1px solid;    
  }
  #signatureCanvas2{    
    border: 1px solid;    
  }  
</style>
<?php 
$row = $dt_client->row();
?>

<div class="col-lg-12 col-12 grid-margin">
  <form action="klinik/pemeriksaan/simpanAwal" method="POST">
    <div class="card">         

      <div class="card-header bg-success" id="headingOne">                  
        <div class="row">
          <div class="col-10">                      
            Kontrak Kerjasama Client                  
          </div>                    
        </div>
      </div>                

      
      <div class="card-body">              
        <div class="row">
                          
          <?php 
          $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();         
          echo $setting->template_kontrak_cucikan;
          ?>

        </div>                  
      </div>
      <div class="card-footer">
        <div class="col-sm-10">
          <div class="row">
            <div class="col-5">
              <input type="hidden" name="id" id="id" value="<?=$row->id?>">
              <?php 
              if($row->status_ttd==0){
              ?>
                <button type="button" data-toggle='modal' style='cursor:pointer' data-target='#pasienTtdModal' class="btn btn-outline-primary mt-2 ml-auto"><i class="fa fa-file-signature"></i> Tanda Tangan Client</button>
              <?php }else{ ?>  
                <div style="text-align: center;">
                  <img style="border: 1px solid;" id="signatureImage" src="<?=cekTtd($row->id,"ttd_client")?>" alt="TTD Client">
                  <p style="margin-top: 10px;">TTD Client</p>
                </div>                      
                <button type="button" disabled class="btn btn-primary mt-2 ml-auto"><i class="fa fa-check"></i> Sudah Tanda Tangan Client</button>
                <button onclick="resetTTDClient()" type="button" class="btn btn-default mt-2">Reset</button>
                <a href="master/client/cetakKontrak?id=<?=$row->id?>" class="btn btn-success mt-2"><i class="fa fa-print"></i> Cetak Kontrak</a>
              <?php } ?>
            </div>            
          </div>
                    
        </div>
                  
      </div>
      
    </div>
  </form>
</div>



<div class="modal fade" data-backdrop="static" data-keyboard="false" id="pasienTtdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">                        
    <div class="modal-content">                          
      <div class="modal-body">
        <div class="row">
          <div id="tengah" class="text-center">
            <canvas id="signatureCanvas1" class="signature-pad-canvas"></canvas>                                
          </div>
        </div>
      </div>
      <div class="modal-footer float-left">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>        
        <button type="button" id="clearButton1" class="btn btn-danger">Ulangi</button>
        <button type="button" id="saveButton1" class="btn btn-success">Simpan</button>                            
      </div>
    </div>                        
  </div>
</div>




<script src="<?=base_url('assets/js/signature_pad.umd.min.js')?>"></script>
<script>
  const canvas1 = document.getElementById('signatureCanvas1');
  const signaturePad1 = new SignaturePad(canvas1);


  document.getElementById('clearButton1').addEventListener('click', () => {
    signaturePad1.clear();
  });


  document.getElementById('saveButton1').addEventListener('click', () => {
    const dataURL1 = signaturePad1.toDataURL();    

    const postData = {
      id: document.getElementById('id').value,
      signature1: dataURL1      
    };

    saveSignature1(postData);
  });  
  

  function saveSignature1(postData) {
    // Kirim data URL ke server menggunakan AJAX atau formulir      
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('Tanda tangan berhasil disimpan di server.');
      }
    };

    const formData = new URLSearchParams(Object.entries(postData)).toString();

    xhr.open('POST', "<?php echo site_url('master/client/ttd_client')?>", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(formData); 

    window.location.reload();
  }    
  function resetTTDClient(){
    var id = document.getElementById('id').value;
    $.ajax({
      url : "<?php echo site_url('master/client/resetTTDClient')?>",
      type:"POST",
      data:"id="+id,
      cache:false,   
      success:function(msg){
        window.location.reload();
      }
    });
  }
</script>
