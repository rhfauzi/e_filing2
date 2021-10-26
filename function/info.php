<?php

function sendsms($nomor,$pesan){
 $date  = date("Y-m-d H:i:s");
 $url   =  "http://192.168.100.1/api/sms"; //tembak data
 $user  = "brins_user_01";
 $token  = "uiVQzCEKVDu9E9S9CS481fn5";
 $fungsi  = "send_single";

    $ch = curl_init($url);
    $jsonData = array(
        'user'  => $user,
        'token' => $token,
        'cmd'   => $fungsi,
        'phone' => $nomor,
        'text'  => $pesan
    );
}

// function infolog($iduser){
// 	$Que = mssql_fetch_assoc(mssql_query("SELECT * FROM usermenu WHERE iduser = '".$iduser."'"));

// 	$res = $Que['groupmenu'];

// 	return $res;
// }

function infolog($iduser){

$Que = mssql_fetch_assoc(mssql_query("SELECT TOP 1 a.*, b.id_pegawai,b.nm_pegawai,b.KodeUnit,c.UnitKerja,d.groupdeskripsi 
                                        FROM usermenu a, user_aplikasi b ,msuker c,groupbsam d
                                        WHERE a.iduser = b.id_pegawai 
                                        AND b.KodeUnit = c.KodeUnit 
                                        AND a.groupmenu = d.groupmenu
                                        AND a.iduser = '".$iduser."' order by idmenuuser desc"));

$res['groupdesc']   = $Que['groupdeskripsi'];
$res['group']       = $Que['groupmenu'];
$res['KodeUnit']    = $Que['KodeUnit'];
$res['UnitKerja']   = $Que['UnitKerja']; //AMBIL DARI SIMSDM
$res['kode_uker']   = $Que['kode_uker'];//AMBIL DARI TABLE USERMENU
$res['nm_pegawai']  = $Que['nm_pegawai'];
$res['id_pegawai']  = $Que['id_pegawai'];

return $res;
}


function infouser($iduser){
    $Que = mssql_fetch_assoc(mssql_query("SELECT * FROM user_aplikasi WHERE id_pegawai = '".$iduser."'"));

    $res = $Que['usernamePegawai'];

    return $res;
}

?>