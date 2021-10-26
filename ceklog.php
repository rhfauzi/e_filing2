<?php
  session_start();
  require('setting/koneksi.php');
  require('function/encdec.php');
  conDB('.','e_filing');

  $enc   =  new encdec();

//$hasil_decrypt  =  $enc->decrypt($passwordnya , true);

  $user   = $_POST['username'];
  $pass   = $_POST['password'];

  $hasil_encrypt  =  $enc->encrypt( $pass , true);

    //$StrLogin   = "SELECT * FROM user_aplikasi WHERE usernamePegawai ='".$user."' AND pass_pegawai = '".$pass."'";
	$cekiduser = mssql_fetch_assoc(mssql_query("SELECT id_pegawai FROM user_aplikasi where usernamePegawai = '".$user."'"));

  $superadmin = mssql_fetch_assoc(mssql_query("SELECT * FROM e_filing.dbo.usermenu WHERE iduser = '".$cekiduser['id_pegawai']."'"));
	
	if($superadmin['groupmenu'] == '1'){ //jika yang login super admin
	$StrLogin   = "SELECT * FROM user_aplikasi WHERE usernamePegawai ='".$user."'";
  
	}else{
	// $StrLogin   = "SELECT a.* FROM user_aplikasi a,e_filing.dbo.usermenu b  
	// 				WHERE a.id_pegawai = b.iduser AND a.usernamePegawai ='".$user."' AND a.pass_pegawai = '".$hasil_encrypt."'";
      $StrLogin   = "SELECT a.* FROM user_aplikasi a,e_filing.dbo.usermenu b  
          WHERE a.id_pegawai = b.iduser AND a.usernamePegawai ='".$user."'";
	}			


    $QueLogin   = mssql_query($StrLogin);
    $cek        = mssql_num_rows($QueLogin);

    if($cek != 0){
        $r = mssql_fetch_assoc($QueLogin);

        $_SESSION['iduser']   = $r['id_pegawai'];
        $_SESSION['nmuser']   = $r['nm_pegawai'];
        $_SESSION['username'] = $r['usernamePegawai'];
        $_SESSION['usercare'] = $r['userCare'];
        $_SESSION['nip']      = $r['kd_pegawai'];

        header("location:main.php");

    }else{
        // echo "<script type='text/javascript'>
        //       alert('maaf Username atau Password salah atau anda tidak memiliki akses');
        //       window.location='index.php';
        //       </script>";

      echo $StrLogin; 

    }
?>