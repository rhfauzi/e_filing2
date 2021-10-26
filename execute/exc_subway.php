<?php
error_reporting(0);
require '../setting/koneksi.php';
require '../function/seqno.php';
require '../function/changeformat.php';
require '../function/encdec.php';

conDB('.','e_filing');
session_start();
$getact  = $_GET['act'];
$postact = $_POST['act'];

//$input_user 	  = $_SESSION['iduser'];
$input_user 	  = '483';
$logdate 		  = date('d-m-Y'); $logtime = date('H:i:s');
$input_date 	  = $logdate." | ".$logtime;


if($getact == 'multi_alokasi'){

}





if($getact == 'approve_box'){

	$id	= $_GET['id'];

	$update_stat = mssql_query("UPDATE msbox set data_status = 'A' WHERE id_box = '".$id."'");
	$cek_data   = mssql_fetch_assoc(mssql_query("SELECT * FROM msbox where id_box = '".$id."'"));

	if($update_stat){
		//-------------------------------- untuk log aktifitas ------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log)values('$activity_update',
																		'approve box',
																		'".$cek_data['kd_lokasi']."',
																		'SUCCESS',
																		'".$input_user."',
																		convert(varchar(200),'$input_date'))");
		//----------------------------------------------------------------------------------------------
		$url = "mid=msbox&alert=1&ket=diapprove";
	}else{
		$url = "mid=msbox&alert=2&ket=diapprove";
	}

	$urlEnc = $edc->encrypt($url,true);
	header("location:../main.php?".$urlEnc."");
}

//-------------------------------------------------------------------------------------------------------------

?>
