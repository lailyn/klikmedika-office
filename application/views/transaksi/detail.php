<div class="form-group row">                      
  <div class="col-sm-12">                        
    <div class="box">    
      <label><h4>Detail Pengeluaran</h4></label>
      <div class="table-responsive">
        <table id="example2" class="table" style="width:100%">
          <thead>
            <tr>
              <td>Uraian</td>                                                  
              <td width="15%">Nominal</td>              
              <td <?php echo $komp ?> width="5%">Aksi</td>
            </tr>
          </thead>
          <tbody>                                  
            <tr <?php echo $komp ?>>              
              <td>
                <input type="text" class="form-control form-control-sm" name="uraian" placeholder="Uraian">                                    
              </td>                                                  
              <td>
                <input type="text" data-type="currency" class="form-control form-control-sm" name="nominal" placeholder="Nominal">                                    
              </td>                                    
              <td>
                <button type="submit" class="btn btn-primary btn-sm">Add</button>
              </td>
            </tr>
            <?php 
            $tot=0;
            $sql = $this->db->query("SELECT * FROM md_pengeluaran_detail WHERE kode_pengeluaran = '$row->kode_pengeluaran'");
            foreach ($sql->result() as $isi) {
              
              echo "
              <tr>
                <td>$isi->uraian</td>                
                <td align='right'>".mata_uang($isi->nominal)."</td>                
                <td $komp>
                  <a class='btn btn-danger btn-sm' onclick=\"return confirm('Anda yakin?')\" href='finance/pengeluaran/delete_detail?id=$isi->id&d=$row->id_pengeluaran'>del</a>
                </td>
              </tr>
              ";
              $tot += $isi->nominal;
            }
            ?>
          </tbody>
          
        </table>
      </div>
    </div>
  </div>
</div>


