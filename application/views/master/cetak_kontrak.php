<!DOCTYPE html>
<base href="<?php echo base_url(); ?>" />
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CETAK KONTRAK KERJASAMA</title>
    <style>
      @media print {
        @page {
          size: 21cm 160cm; /* lebar x tinggi → contoh F4 atau lebih panjang */
          margin: 1.5cm 2cm 1.5cm 2cm;
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
      <td colspan="4">
        <?php $dts = $this->m_admin->getByID("md_brand","id",$client->id_brand)->row(); ?>
        <img src="assets/uploads/sites/<?php echo $dts->bg_header ?>">
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
  <table width="100%" border="0" align="">      
    <tr>
      <td><i></i></td>   
      <td align="center">Jambi, <?php echo gmdate(" d F Y", time()+60*60*7); ?></td>
    </tr>
    
    <tr>
      <td></td>
      <td align="center"><?=$setting->perusahaan?></td>
    </tr>        
    <tr>
      <td align="center">
        <div>
          <p style="margin-top: 10px;">PIHAK KEDUA</p><br>
          <img width="250px" id="signatureImage" src="<?=cekTtd($isinya->id,"ttd_client")?>" alt="TTD Client">
          <p style="margin-top: 10px;"><?=$isinya->nama_lengkap?></p>
        </div>                      
      </td>
      <td align="center">  
        <div>
          <p style="margin-top: 10px;">PIHAK PERTAMA</p><br>
          <img width="150px" id="signatureImage" src="assets/im493/<?=$setting->ttdceo?>" alt="TTD CEO">
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