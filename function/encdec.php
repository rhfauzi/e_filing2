<?php


class encdec
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
 ?>