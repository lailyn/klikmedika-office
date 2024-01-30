   

   
    <div class="row">
      <div class="col-12 grid-margin">        
                
        <div class="card">
          
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example1" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th>Nama</th>                      
                      <th>No HP</th>                           
                      <th>Email</th>                                       
                      <th>Alamat</th>                                                 
                    </tr>
                  </thead>
                  <tbody> 
                  <?php                   
                  $no=1;
                  $where="";$total=0;                  
                    
                  $sql = $this->db->query("SELECT * FROM md_konsumen ORDER BY id_konsumen DESC"); 
                                    
                  foreach ($sql->result() as $isi) {                                        

                    
                    echo "
                    <tr>
                      <td>$no</td>                      
                      <td>$isi->nama_lengkap</td>                      
                      <td>$isi->no_hp</td>                      
                      <td>$isi->email</td>                      
                      <td>$isi->alamat</td>                                            
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


