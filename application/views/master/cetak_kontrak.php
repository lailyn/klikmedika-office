<!DOCTYPE html>
<base href="<?php echo base_url(); ?>" />
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CETAK KONTRAK KERJASAMA</title>
    <style>
      @media print {
        @page {
          size: 21cm 40cm; /* lebar x tinggi → contoh F4 atau lebih panjang */
          margin: 1cm;
        }

        body {
          margin: 0;
        }
      }
    </style>

  </head>
<body onload="printPage()">
  <table border="0" width="100%" align="center">
    <tr>   
      <td>
        <img width="150px" src="assets/im493/<?php echo $setting->logo ?>">
      </td>
      <td></td>   
      <td></td>   
      <td width="40%" align="right">        
          <p class="text-center">
            <?php echo $setting->alamat ?><br>
            <strong>Telp :</strong> <?php echo $setting->no_telp ?>  
            <strong>Email:</strong> <?php echo $setting->email ?> <br>
            <strong>Website :</strong> <?php echo $setting->url ?>
          </p>
      </td>      
    </tr>
    <tr>
      <td colspan="4"><hr></td>
    </tr>    
  </table>
  
  <div style="margin-left: 10px;margin-right: 10px;">
        <br>
        <?php                  
        $isinya = $this->m_admin->getByID("md_client","id",$client->id)->row();
        $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();                         
        // echo $htmlContent = $setting->template_kontrak_cucikan;        
        
        $tgl = substr($isinya->tgl_daftar, 8,2);
        $bulan = substr($isinya->tgl_daftar, 5,2);
        $tahun = substr($isinya->tgl_daftar, 0,4);

        $suratAsli = $setting->template_kontrak_cucikan;
        $replacements = array(
            "{{kode}}" => $isinya->kode_faskes,
            "{{pic}}" => $isinya->nama_lengkap,
            "{{alamat}}" => $isinya->alamat,
            "{{instansi}}" => $isinya->nama_faskes,
            "{{no_hp}}" => $isinya->no_hp,
            "{{lama}}" => $isinya->lama,
            "{{nominal}}" => mata_uang_help($isinya->nominal),
            "{{tgl}}" => $tgl,          
            "{{bulan}}" => $bulan,
            "{{tahun}}" => $tahun            
        );

        $suratAsli = str_replace(array_keys($replacements), array_values($replacements), $suratAsli);


        echo $suratAsli;
        ?>
  </div>
  <table width="80%" border="0" align="">      
    <tr>
      <td><i></i></td>   
      <td align="center">Jambi, <?php echo gmdate(" d F Y", time()+60*60*7); ?></td>
    </tr>
    
    <tr>
      <td></td>
      <td align="center"><?=$setting->perusahaan?></td>
    </tr>    
    <tr>
      <td colspan="2"><br></td>
    </tr>
    <tr>
      <td align="center">
        <div>
          <p style="margin-top: 10px;">PIHAK KEDUA</p>
          <img width="250px" id="signatureImage" src="<?=cekTtd($isinya->id,"ttd_client")?>" alt="TTD Client">
          <p style="margin-top: 10px;"><?=$isinya->nama_lengkap?></p>
        </div>                      
      </td>
      <td align="center">  
        <div>
          <p style="margin-top: 10px;">PIHAK PERTAMA</p>
          <img width="250px" id="signatureImage" src="assets/im493/<?=$setting->ttdceo?>" alt="TTD CEO">
          <p style="margin-top: 10px;">Lailyn Puad, S.Kom., M.Kom.</p>
        </div>                      

      </td>
    </tr>
  </table>
</body>

<script>
  function printPage() {
      window.print();
  }
</script>