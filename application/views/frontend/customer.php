<div class="container" style="padding-top:140px;margin-bottom: 20px;">
    <?php include 'aside.php'; ?>
    <?php                       
    if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {                    
    ?>                  
    <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable mt-2">
      <strong><?php echo $_SESSION['pesan'] ?></strong>                    
    </div>
    <?php
    }
    $_SESSION['pesan'] = '';                        

    ?>
    
        
    <form action="profilPost" method="POST" class="row g-3 mt-3">
        <div class="col-md-4">
            <label for="inputCity" class="form-label">Nama Lengkap</label>
            <input type="hidden" name="id_user" value="<?=$dt_user->id_user?>">
            <input type="text" value="<?=$dt_user->nama_lengkap?>" name="nama_lengkap" class="form-control" id="inputCity">
        </div>      
        <div class="col-md-4">
            <label for="inputCity" class="form-label">Email</label>
            <input type="text" value="<?=$dt_user->email?>" name="email" class="form-control" id="inputCity">
        </div>      
        <div class="col-md-4">
            <label for="inputCity" class="form-label">Password (Kosongkan Jika Tidak Diubah)</label>
            <input type="password" value="" name="password" class="form-control" id="inputCity">
        </div>      
        <div class="col-md-4">
            <label for="inputZip" class="form-label">No HP</label>
            <input type="text" name="no_hp" value="<?=$dt_user->no_hp?>" class="form-control" id="inputZip">
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Ubah Profil</button>        
            <button class="btn btn-default" type="reset">Reset</button>        
        </div>    
    </form>
    
</div>