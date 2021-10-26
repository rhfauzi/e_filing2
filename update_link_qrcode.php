<?php
include "setting/koneksi.php";
include "function/changeformat.php";
kon_db();


class encrypt
 {
 public $ky;
 public $iv;
 public $size_ky;
 public $size_iv;
 public $static_ky;
 public $static_iv;
 public $chip = MCRYPT_TRIPLEDES;  // MCRYPT_RIJNDAEL_256
 public $mode = MCRYPT_MODE_CFB;

   function __construct()
   {
    //get key + iv size
    $this->size_ky = mcrypt_get_key_size($this->chip, $this->mode);
    $this->size_iv = mcrypt_get_iv_size($this->chip, $this->mode);
    
    //set dynamic key + iv
    if (isset($_SESSION['CoEncKey']) and isset($_SESSION['CoEncIV'])){
     $this->ky = $_SESSION['CoEncKey'];
     $this->iv = pack("H*", $_SESSION['CoEncIV']);
    }
  
    //set static key + iv
    $secret = pack("H*", "731d038d1d35d9cd0f002440be99b4d4ba235548ef50bd1c1fd632a79fd63187731d038d1d35d9cd0f002440be99b4d4ba235548ef50bd1c1fd632a79fd63187");
    //$this->static_ky = substr(md5(date("Ymd")),0 ,$this->size_ky);
    $this->static_ky = substr(md5("TSI_MANTAP"),0 ,$this->size_ky);
    $this->static_iv = substr($secret, 0, $this->size_iv);
   }
   //end

   function CreateKeyIV()
   {
    $this->iv = mcrypt_create_iv($this->size_iv, MCRYPT_RAND);
    $this->ky = substr(md5(uniqid(rand(), true)),0 ,$this->size_ky);;
   }

   function encrypt($data, $use_static = false)
   {
    $zip = gzdeflate($data, 9);
    if ($use_static){
     $has = mcrypt_encrypt($this->chip, $this->static_ky, $zip, $this->mode, $this->static_iv);
    } else {
     $has = mcrypt_encrypt($this->chip, $this->ky, $zip, $this->mode, $this->iv);
    }
    return bin2hex(mhash(MHASH_CRC32, $data).$has);
   }
//end

   function decrypt($data, $use_static = false)
   {
    if (empty($data)){
     return false;
    }
    $data = pack("H*",$data);
    if ($use_static){
     $zip = mcrypt_decrypt($this->chip, $this->static_ky, substr($data, 4), $this->mode, $this->static_iv);
    } else {
     $zip = mcrypt_decrypt($this->chip, $this->ky, substr($data, 4), $this->mode, $this->iv);
    }
    $has = gzinflate($zip);
    if (mhash(MHASH_CRC32, $has) === substr($data,0 , 4)){
     return $has;
    } else {
     return false;
    }
   }

 }
// ======================================================================================================

$enc    =  new encrypt(); 




$cek = mssql_query("SELECT * FROM arsip");
$url        = "http://portal.brins.co.id/e_filing/view/qrarsip_result.php?id=";
$no =1;

while($res = mssql_fetch_assoc($cek)){

$hasil_encrypt  =  $enc->encrypt($res['kd_arsip'] , true);

$link_qrcode  = $url.$hasil_encrypt."";

    $update = mssql_query("UPDATE arsip set link_qrcode = '".$link_qrcode."' 
                                        WHERE kd_arsip = '".$res['kd_arsip']."' 
                                        AND link_qrcode = ''");

    echo "no = ".$no." UPDATE arsip set link_qrcode = '".$link_qrcode."' 
                                        WHERE kd_asset = '".$res['kd_asset']."' 
                                        AND link_qrcode =''<br><br>";
$no++;
}




// ======= UPDATA QRCODE LOKASI =========

$cek_lok = mssql_query("SELECT * FROM mslokasi");
$url_lok      = "http://portal.brins.co.id/e_filing/view/qrlokasi_result.php?id=";
$no=1;

while($res_lok = mssql_fetch_assoc($cek_lok)){


  $kd_lokasi  = $res_lok['kd_lokasi'];
  $ID         = $kd_lokasi;

  $hasil_encrypt_lok  =  $enc->encrypt($ID , true); 

  $link_qrcode_lok = $url_lok.$hasil_encrypt_lok."";

  $update = mssql_query("UPDATE mslokasi set link_qrcode = '".$link_qrcode_lok."' 
                                      WHERE id_lokasi = '".$res_lok['id_lokasi']."'
                                      AND link_qrcode = ''");

  echo "no = ".$no." UPDATE mslokasi set link_qrcode = '".$link_qrcode_lok."' 
                                      WHERE id_lokasi = '".$res_lok['id_lokasi']."'
                                      AND link_qrcode = ''<br><br>";
$no++;

}

// ======================================


// ======= UPDATA QRCODE RAK =========

$cek_rak = mssql_query("SELECT * FROM msrak");
$url_rak      = "http://portal.brins.co.id/e_filing/view/qrrak_result.php?id=";
$no=1;

while($res_rak = mssql_fetch_assoc($cek_rak)){


  $kd_rak  = $res_rak['kd_rak'];
  $ID      = $kd_rak;

  $hasil_encrypt_rak  =  $enc->encrypt($ID , true); 

  $link_qrcode_rak = $url_rak.$hasil_encrypt_rak."";

  $update = mssql_query("UPDATE msrak set link_qrcode = '".$link_qrcode_rak."' 
                                      WHERE id_rak = '".$res_rak['id_rak']."'
                                      AND link_qrcode = ''");

  echo "no = ".$no." UPDATE msrak set link_qrcode = '".$link_qrcode_rak."' 
                                      WHERE id_rak = '".$res_rak['id_rak']."'
                                      AND link_qrcode = ''<br><br>";
$no++;

}

// ======================================


// ======= UPDATA QRCODE BOX =========

$cek_box = mssql_query("SELECT * FROM msbox");
$url_box      = "http://portal.brins.co.id/e_filing/view/qrbox_result.php?id=";
$no=1;

while($res_box = mssql_fetch_assoc($cek_box)){


  $kd_box  = $res_box['kd_box'];
  $ID      = $kd_box;

  $hasil_encrypt_box  =  $enc->encrypt($ID , true); 

  $link_qrcode_box = $url_box.$hasil_encrypt_box."";

  $update = mssql_query("UPDATE msbox set link_qrcode = '".$link_qrcode_box."' 
                                      WHERE id_box = '".$res_box['id_box']."'
                                      AND link_qrcode = ''");

  echo "no = ".$no." UPDATE msbox set link_qrcode = '".$link_qrcode_box."' 
                                      WHERE id_box = '".$res_box['id_box']."'
                                      AND link_qrcode = ''<br><br>";
$no++;

}

// ======================================