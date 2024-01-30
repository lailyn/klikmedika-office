     

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


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            Notification List
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Tipe Notifikasi</th>
                      <th>Judul</th>                      
                      <th>Isi</th> 
                      <th>Status</th>                     
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no=1;
                  $sql = $this->db->query("SELECT status,id_notifikasi, tipe_notifikasi,judul,isi FROM md_notifikasi WHERE id_user = 0 ORDER BY id_notifikasi DESC");
                  foreach ($sql->result() as $isi) {
                    if($isi->tipe_notifikasi == 'promo'){                      
                      $link = "m4suk4dm1n/redirect/front-promo/promo";
                    }elseif($isi->tipe_notifikasi == 'order'){                      
                      $link = "m4suk4dm1n/redirect/trans-order/order";
                    }elseif($isi->tipe_notifikasi == 'visit'){                      
                      $link = "m4suk4dm1n/redirect/trans-visit/visit";
                    }elseif($isi->tipe_notifikasi == 'chat'){                      
                      $link = "m4suk4dm1n/redirect/trans-chat/chat";
                    }else{
                      $link = "";
                    }

                    if($isi->status==0){      
                      $status = "<label class='badge badge-danger'>unread</label>";
                    }elseif($isi->status==1){      
                      $status = "<label class='badge badge-success'>read</label>";
                    }
                    echo "
                    <tr>
                      <td>$no</td>
                      <td><a href='$link'>$isi->tipe_notifikasi</a></td>
                      <td>$isi->judul</td>
                      <td>$isi->isi</td>                      
                      <td>$status</td>                      
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
