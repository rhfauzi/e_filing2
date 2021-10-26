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

$activity_add     = 'TAMBAH';
$activity_edit    = 'UBAH';
$activity_del  	  = 'HAPUS';
$activity_update  = 'UBAH STATUS';

$data_status 	  = 'N';

//$input_user 			= $_SESSION['iduser'];
$input_user 	  = '483';
$logdate 		  = date('d-m-Y'); $logtime = date('H:i:s');
$input_date 	  = $logdate." | ".$logtime;


//============================ URL KODE QRCODE ===================================
$edc   =  new encdec();
// =================================================================================


//---------------------------------------------------- INSERT KATEGORY -----------------------------
if($postact == 'addkategori'){

$nm_kategori	= $_POST['nm_kategori'];
$kd_kategori	= kode_kategori($nm_kategori);

$cekdata = mssql_num_rows(mssql_query("SELECT nm_kategori FROM mskategori WHERE nm_kategori = '".$nm_kategori."'"));

	if($cekdata > 0){
		$url    = "mid=addkategori&alert=2&nm_kategori=".$nm_kategori;
	}else{

	$sql	=	mssql_query("INSERT INTO mskategori(kd_kategori,
													nm_kategori,
													data_status,
													input_user,
													input_date)VALUES('$kd_kategori',
																		'$nm_kategori',
																		'$data_status',
																		'$input_user',
																		'$input_date')");

		if($sql){
		//-------------------------------- untuk log aktifitas ------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log)values('$activity_add',
																		'kategori',
																		'$kd_kategori',
																		'SUCCESS',
																		'$input_user',
																		convert(varchar(200),'$input_date'))");
		//------------------------------------------------------------------------------------------------
			$url    = "mid=addkategori&alert=1";
		}else{
			$url    = "mid=addkategori&alert=3";
		}
		
	}

	$urlEnc = $edc->encrypt($url,true);
	echo $urlEnc;
}
//---------------------------------------------------- UPDATE KATEGORY ---------------------------------------
elseif($postact == 'editkategori'){
$id_kategori	=	$_POST['id_kategori'];
$kd_kategori	=	$_POST['kd_kategori'];
$nm_kategori	=	$_POST['nm_kategori'];

$cekdata = mssql_num_rows(mssql_query("SELECT nm_kategori FROM mskategori WHERE kd_kategori != '".$kd_kategori."' and nm_kategori = '".$nm_kategori."'"));

	if($cekdata > 0){
		$url    = "mid=editkategori&alert=2&id_kategori=".$id_kategori."&nm_kategori=".$nm_kategori;
	}else{


	$sql	=	mssql_query("UPDATE mskategori SET kd_kategori		= '$kd_kategori',
													nm_kategori 	= '$nm_kategori'
													WHERE id_kategori = '$id_kategori'");

		if($sql){
		//-------------------------------- untuk log aktifitas ------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log)values('$activity_edit',
																		'kategori',
																		'$kd_kategori',
																		'SUCCESS',
																		'$input_user',
																		convert(varchar(200),'$input_date'))");
		//-----------------------------------------------------------------------------------------------
			$url    = "mid=editkategori&alert=1&id=".$id_kategori;
		}else{
			$url    = "mid=editkategori&alert=3&id=".$id_kategori;
		}
		
	}

	$urlEnc = $edc->encrypt($url,true);
	echo $urlEnc;


}
//---------------------------------------------------- DELETE KATEGORY ---------------------------------------
elseif($getact == 'delkategori'){

$id		=	$_GET['id'];

$getkode = mssql_fetch_assoc(mssql_query("SELECT * FROM mskategori WHERE id_kategori = '".$id."'"));
$kd_kategori = $getkode['kd_kategori'];
$status = 'PENDING';

//-------------------------------- untuk log aktifitas ------------------------------------------
$actlog = mssql_query("INSERT INTO log_activity (activity,
													menu,
													kode,
													status,
													user_log,
													date_log)values('$activity_del',
																	'kategori',
																	'$kd_kategori',
																	'$status',
																	'$input_user',
																	convert(varchar(200),'$input_date'))");
//------------------------------------------------------------------------------------------------

$sql	= mssql_query("DELETE FROM mskategori WHERE id_kategori	= '".$id."'");

	if($sql){
		$stat = 'SUCCESS';
		$upstat = mssql_query("UPDATE log_activity set status = '".$stat."' where id_activity =(select top 1 id_activity from log_activity where activity ='HAPUS' and menu='kategori' order by id_activity desc)");
		$url    = "mid=mskategori&alert=1&ket=dihapus";
	}else{
		$url    = "mid=mskategori&alert=2&ket=dihapus";
	}
	$urlEnc = $edc->encrypt($url,true);
	header("location:../main.php?".$urlEnc."");

}


//---------------------------------------------------- APPROVE KATEGORI ---------------------------------------

if($getact == 'approve_kategori'){

	$id	= $_GET['id'];

	$update_stat = mssql_query("UPDATE mskategori set data_status = 'A' WHERE id_kategori = '".$id."'");
	$cek_data   = mssql_fetch_assoc(mssql_query("SELECT * FROM mskategori where id_kategori = '".$id."'"));

	if($update_stat){
		//-------------------------------- untuk log aktifitas ------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log)values('$activity_update',
																		'approve kategori',
																		'".$cek_data['kd_kategori']."',
																		'SUCCESS',
																		'".$input_user."',
																		convert(varchar(200),'$input_date'))");
		//----------------------------------------------------------------------------------------------
		$url    = "mid=mskategori&alert=1&ket=diapprove";
	}else{
		$url    = "mid=mskategori&alert=2&ket=diapprove";
	}
	$urlEnc = $edc->encrypt($url,true);
	header("location:../main.php?".$urlEnc."");
}

//-------------------------------------------------------------------------------------------------------------




//---------------------------------------------------- INSERT TYPE ---------------------------------------
// if($postact == 'addtype'){
// $kd_kategori	= $_POST['kd_kategori'];
// $type			= $_POST['type'];


// $kd_type = auto_kd_type($kd_kategori,$type);

// $sql	=	mssql_query("INSERT INTO mstype(kd_kategori,
// 												kd_type,
// 												nm_type,
// 												data_status,
// 												input_user,
// 												input_date)VALUES('$kd_kategori',
// 																	'$kd_type',
// 																	'$type',
// 																	'$data_status',
// 																	'$input_user',
// 																	'$input_date')");
// if($sql){
// //-------------------------------- untuk log aktifitas ------------------------------------------
// $actlog = mssql_query("INSERT INTO log_activity (activity,
// 												menu,
// 												kode,
// 												status,
// 												user_log,
// 												date_log)values('$activity_add',
// 																'type',
// 																'$kd_type',
// 																'SUCCESS',
// 																'$input_user',
// 																convert(varchar(200),'$input_date'))");
// //----------------------------------------------------------------------------------------------
// }
// //if($sqlmenu){
// //alert succes or error ada didalam ajax nya
// //}else{}
// }
// //---------------------------------------------------- UPDATE TYPE ---------------------------------------
// elseif($postact == 'edittype'){
// $id_type		=	$_POST['id_type'];
// $kd_kategori	=	$_POST['kd_kategori'];
// $type			=	$_POST['type'];

// $sql	=	mssql_query("
// 				UPDATE mstype SET
// 				kd_kategori		= '$kd_kategori',
// 				nm_type 		= '$type'
// 				WHERE id_type 	= '$id_type'
// 				");

// if($sql){
// $getkode = mssql_fetch_assoc(mssql_query("SELECT * FROM mstype WHERE id_type = '".$id."'"));
// $kd_type = $getkode['kd_type'];

// //-------------------------------- untuk log aktifitas ------------------------------------------
// $actlog = mssql_query("INSERT INTO log_activity (activity,
// 												menu,
// 												kode,
// 												status,
// 												user_log,
// 												date_log)values('$activity_edit',
// 																'type',
// 																'$kd_type',
// 																'SUCCESS',
// 																'$input_user',
// 																convert(varchar(200),'$input_date'))");
// //-----------------------------------------------------------------------------------------------
// }

// //if($sqlmenu){
// //alert succes or error ada didalam ajax nya
// //}else{}
// }
// //---------------------------------------------------- DELETE TYPE ---------------------------------------
// elseif($getact == 'deltype'){

// $id		=	$_GET['id'];

// $getkode = mssql_fetch_assoc(mssql_query("SELECT * FROM mstype WHERE id_type = '".$id."'"));
// $kd_type = $getkode['kd_type'];
// $status = 'PENDING';

// //-------------------------------- untuk log aktifitas ------------------------------------------
// $actlog = mssql_query("INSERT INTO log_activity (activity,
// 												menu,
// 												kode,
// 												status,
// 												user_log,
// 												date_log)values('$activity_del',
// 																'type',
// 																'$kd_type',
// 																'$status',
// 																'$input_user',
// 																convert(varchar(200),'$input_date'))");
// //------------------------------------------------------------------------------------------------


// $sql	=	mssql_query("DELETE FROM mstype WHERE id_type	= '".$id."'");

// 	if($sql){
// 		$stat = 'SUCCESS';
// 		$upstat = mssql_query("UPDATE log_activity set status = '".$stat."' where id_activity =(select top 1 id_activity from log_activity where activity ='HAPUS' and menu='type' order by id_activity desc)");
// 		header("location:../main.php?mid=mstype&alert=1");
// 	}else{
// 		header("location:../main.php?mid=mstype&alert=2");
// 	}
// }

// //-------------------------------------------------------------------------------------------------------------



// //---------------------------------------------------- APPROVE TYPE ---------------------------------------

// if($getact == 'approve_type'){

// 	$id	= $_GET['id'];

// 	$update_stat = mssql_query("UPDATE mstype set data_status = 'A' WHERE id_type = '".$id."'");
// 	$cek_data   = mssql_fetch_assoc(mssql_query("SELECT * FROM mstype where id_type = '".$id."'"));

// 	if($update_stat){
// 		//activitylog----------------------------------------------------------------------------------
// 		$actlog = mssql_query("INSERT INTO log_activity (activity,
// 														menu,
// 														kode,
// 														status,
// 														user_log,
// 														date_log)values('$activity_update',
// 																		'approve type',
// 																		'".$cek_data['kd_kategori']."',
// 																		'SUCCESS',
// 																		'".$input_user."',
// 																		convert(varchar(200),'$input_date'))");
// 		//----------------------------------------------------------------------------------------------
// 		header("location:../main.php?mid=mstype&alert=3");
// 	}else{
// 		header("location:../main.php?mid=mstype&alert=2");
// 	}
// }

// //-------------------------------------------------------------------------------------------------------------


//---------------------------------------------------- INSERT LOKASI ---------------------------------------
if($postact == 'addlokasi'){

$nm_lokasi	= $_POST['nm_lokasi'];
$alamat 	= $_POST['alamat'];

$kd_lokasi = auto_kd_lokasi();


$ceklokasi = mssql_num_rows(mssql_query("SELECT * FROM mslokasi WHERE lokasi like '%".$nm_lokasi."%' "));

	if($ceklokasi > 0){
		//echo $nm_lokasi;
		$url    = "mid=addlokasi&alert=2&nm_lokasi=".$nm_lokasi;
	}else{

		//---------------------------- untuk link qrcode --------------------------------
		$ID     		= $kd_lokasi;
		$hasil_encrypt  = $edc->encrypt($ID , true);
		$url      		= "http://portal.brins.co.id/e_filing/view/qrlokasi_result.php?id=";
		$link_qrcode 	= $url.$hasil_encrypt."";
		//-------------------------------------------------------------------------------

		$sql	   = mssql_query("INSERT INTO mslokasi(kd_lokasi,
														lokasi,
														alamat,
														link_qrcode,
														data_status,
													    input_user,
														input_date)VALUES('$kd_lokasi',
																			'$nm_lokasi',
																			'$alamat',
																			'$link_qrcode',
																			'$data_status',
																		    '$input_user',
																		    '$input_date')");

		if($sql){
		$kode = $kd_lokasi;

		//-------------------------------- untuk log aktifitas ------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log
														)values('$activity_add',
																'lokasi',
																'$kode',
																'SUCCESS',
																'$input_user',
																convert(varchar(200),'$input_date'))");
		//-----------------------------------------------------------------------------------------------
		
			$url    = "mid=addlokasi&alert=1";
	
		}else{
			$url    = "mid=addlokasi&alert=3";
		}

		
	}

	$urlEnc = $edc->encrypt($url,true);
	echo $urlEnc;
}
//---------------------------------------------------- UPDATE lokasi ---------------------------------------
elseif($postact == 'editlokasi'){
$id_lokasi	=	$_POST['id_lokasi'];
$nm_lokasi	=	$_POST['nm_lokasi'];
$alamat		=	$_POST['alamat'];


$getcode  	= mssql_fetch_assoc(mssql_query("SELECT * FROM mslokasi WHERE id_lokasi = '".$id_lokasi."'"));
$kd_lokasi  = $getcode['kd_lokasi'];
$lokasi  	= $getcode['lokasi'];
$kode 		= $kd_lokasi;

$ceklokasi = mssql_num_rows(mssql_query("SELECT * FROM mslokasi WHERE lokasi != '".$lokasi."' AND lokasi like '%".$nm_lokasi."%' "));

	if($ceklokasi > 0){
		$url    = "mid=editlokasi&alert=2&id=".$id_lokasi."&nm_lokasi=".$nm_lokasi;
	}else{

		$sql	=	mssql_query("UPDATE mslokasi SET lokasi 	= '$nm_lokasi',
													 alamat 	= '$alamat'
												WHERE id_lokasi = '$id_lokasi'");

		if($sql){
		
		//-------------------------------- untuk log aktifitas ------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log)values('$activity_edit',
																		'lokasi',
																		'$kode',
																		'SUCCESS',
																		'$input_user',
																		convert(varchar(200),'$input_date'))");
		//-----------------------------------------------------------------------------------------------
			$url    = "mid=editlokasi&alert=1&id=".$id_lokasi;
	
		}else{
			$url    = "mid=addlokasi&alert=3&id=".$id_lokasi;
		}

		
	}

	$urlEnc = $edc->encrypt($url,true);
	echo $urlEnc;

}
//---------------------------------------------------- DELETE lokasi ---------------------------------------
elseif($getact == 'dellokasi'){

$id		=	$_GET['id'];

$getkode 	= mssql_fetch_assoc(mssql_query("SELECT * FROM mslokasi WHERE id_lokasi = '".$id."'"));
$kd_uker 	= $getkode['kd_uker'];
$kd_lokasi 	= $getkode['kd_lokasi'];
$kode 		= $kd_uker."/".$kd_lokasi;
$status 	= 'PENDING';

//-------------------------------- untuk log aktifitas ------------------------------------------
$actlog = mssql_query("INSERT INTO log_activity (activity,
												menu,
												kode,
												status,
												user_log,
												date_log)values('$activity_del',
																'lokasi',
																'$kode',
																'$status',
																'$input_user',
																convert(varchar(200),'$input_date'))");
//-------------------------------------------------------------------------------------------------

	$sql	=	mssql_query("DELETE FROM mslokasi WHERE id_lokasi	= '".$id."'");

	if($sql){
		$stat = 'SUCCESS';
		$upstat = mssql_query("UPDATE log_activity set status = '".$stat."' where id_activity =(select top 1 id_activity from log_activity where activity ='HAPUS' and menu='lokasi' order by id_activity desc)");
		$url    = "mid=mslokasi&alert=1&ket=dihapus";
	}else{
		$url    = "mid=mslokasi&alert=2&ket=dihapus";
	}
	$urlEnc = $edc->encrypt($url,true);
	header("location:../main.php?".$urlEnc."");
}

//-------------------------------------------------------------------------------------------------------------


//---------------------------------------------------- APPROVE lokasi ---------------------------------------

if($getact == 'approve_lokasi'){

	$id	= $_GET['id'];

	$update_stat = mssql_query("UPDATE mslokasi set data_status = 'A' WHERE id_lokasi = '".$id."'");
	$cek_data    = mssql_fetch_assoc(mssql_query("SELECT * FROM mslokasi where id_lokasi = '".$id."'"));
	$kode 		 = $cek_data['kd_uker']."/".$cek_data['kd_lokasi'];

	if($update_stat){
		//-------------------------------- untuk log aktifitas ------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log)values('$activity_update',
																		'approve lokasi',
																		'".$kode."',
																		'SUCCESS',
																		'".$input_user."',
																		convert(varchar(200),'$input_date'))");
		//----------------------------------------------------------------------------------------------
		$url = "mid=mslokasi&alert=1&ket=diapprove";
	}else{
		$url = "mid=mslokasi&alert=2&ket=diapprove";
	}

	$urlEnc = $edc->encrypt($url,true);
	header("location:../main.php?".$urlEnc."");
}

//-------------------------------------------------------------------------------------------------------------






//---------------------------------------------------- INSERT RAK ---------------------------------------
if($postact == 'addrak'){
$kd_lokasi	= $_POST['kd_lokasi'];

$kd_rak = auto_kd_rak();

//---------------------------- untuk link qrcode ------------------------------------------
$ID     		= $kd_rak;
$hasil_encrypt  = $edc->encrypt($ID , true);
$url      		= "http://portal.brins.co.id/e_filing/view/qrrak_result.php?id=";
$link_qrcode 	= $url.$hasil_encrypt."";
//--------------------------------------------------------------------------------------------

$sql	=	mssql_query("INSERT INTO msrak(kd_lokasi,
											kd_rak,
											link_qrcode,
											data_status,
											input_user,
											input_date)VALUES('$kd_lokasi',
																'$kd_rak',
																'$link_qrcode',
																'$data_status',
																'$input_user',
																'$input_date')");
	if($sql){
	//-------------------------------- untuk log aktifitas ------------------------------------------
	$actlog = mssql_query("INSERT INTO log_activity (activity,
													menu,
													kode,
													status,
													user_log,
													date_log)values('$activity_add',
																	'rak',
																	'$kd_rak',
																	'SUCCESS',
																	'$input_user',
																	convert(varchar(200),'$input_date'))");
	//--------------------------------------------------------------------------------------------------

		$url    = "mid=addrak&alert=1&kd_lokasi=".$kd_lokasi;
	
	}else{
		$url    = "mid=addrak&alert=2";
	}


	$urlEnc = $edc->encrypt($url,true);
	echo $urlEnc;

}

//---------------------------------------------------- UPDATE RAK ---------------------------------------
elseif($postact == 'editrak'){

$id_rak		=	$_POST['id_rak'];
$kd_lokasi	=	$_POST['kd_lokasi'];

$sql	=	mssql_query("
				UPDATE msrak SET kd_lokasi		= '$kd_lokasi'
								WHERE id_rak 	= '$id_rak'
								");

	if($sql){
	$getkode = mssql_fetch_assoc(mssql_query("SELECT * FROM msrak WHERE id_rak = '".$id_rak."'"));
	$kd_rak = $getkode['kd_rak'];

	//-------------------------------- untuk log aktifitas ------------------------------------------
	$actlog = mssql_query("INSERT INTO log_activity (activity,
													menu,
													kode,
													status,
													user_log,
													date_log)values('$activity_edit',
																	'rak',
																	'$kd_rak',
																	'SUCCESS',
																	'$input_user',
																	convert(varchar(200),'$input_date'))");
	//------------------------------------------------------------------------------------------------
		$url    = "mid=editrak&alert=1&id=".$id_rak;
	
	}else{
		$url    = "mid=editrak&alert=2&id=".$id_rak;
	}


	$urlEnc = $edc->encrypt($url,true);
	echo $urlEnc;
}
//---------------------------------------------------- DELETE RAK ---------------------------------------
elseif($getact == 'delrak'){

$id		=	$_GET['id'];

$getkode = mssql_fetch_assoc(mssql_query("SELECT * FROM msrak WHERE id_rak = '".$id."'"));
$kd_rak = $getkode['kd_rak'];
$status = 'PENDING';

//-------------------------------- untuk log aktifitas ------------------------------------------
$actlog = mssql_query("INSERT INTO log_activity (activity,
												menu,
												kode,
												status,
												user_log,
												date_log)values('$activity_del',
																'rak',
																'$kd_rak',
																'$status',
																'$input_user',
																convert(varchar(200),'$input_date'))");
//------------------------------------------------------------------------------------------------


$sql	=	mssql_query("DELETE FROM msrak WHERE id_rak	= '".$id."'");

	if($sql){
		$stat = 'SUCCESS';
		$upstat = mssql_query("UPDATE log_activity set status = '".$stat."' where id_activity =(select top 1 id_activity from log_activity where activity ='HAPUS' and menu='rak' order by id_activity desc)");
		$url = "mid=msrak&alert=1&ket=dihapus";
	}else{
		$url = "mid=msrak&alert=2&ket=dihapus";
	}

	$urlEnc = $edc->encrypt($url,true);
	header("location:../main.php?".$urlEnc."");
}

//-------------------------------------------------------------------------------------------------------------



//---------------------------------------------------- APPROVE RAK ---------------------------------------

if($getact == 'approve_rak'){

	$id	= $_GET['id'];

	$update_stat = mssql_query("UPDATE msrak set data_status = 'A' WHERE id_rak = '".$id."'");
	$cek_data   = mssql_fetch_assoc(mssql_query("SELECT * FROM msrak where id_rak = '".$id."'"));

	if($update_stat){
		//-------------------------------- untuk log aktifitas ------------------------------------------
		$actlog = mssql_query("INSERT INTO log_activity (activity,
														menu,
														kode,
														status,
														user_log,
														date_log)values('$activity_update',
																		'approve rak',
																		'".$cek_data['kd_lokasi']."',
																		'SUCCESS',
																		'".$input_user."',
																		convert(varchar(200),'$input_date'))");
		//----------------------------------------------------------------------------------------------
		$url = "mid=msrak&alert=1&ket=diapprove";
	}else{
		$url = "mid=msrak&alert=2&ket=diapprove";
	}

	$urlEnc = $edc->encrypt($url,true);
	header("location:../main.php?".$urlEnc."");
}

//-------------------------------------------------------------------------------------------------------------






//---------------------------------------------------- INSERT BOX ---------------------------------------
if($postact == 'addbox'){

$kd_rak		= $_POST['kd_rak'];
$kd_box 	= auto_kd_box();
$deskripsi	= $_POST['deskripsi'];

//---------------------------- untuk link qrcode --------------------------------
$ID     		= $kd_box;
$hasil_encrypt  = $edc->encrypt($ID , true);
$url      		= "http://portal.brins.co.id/e_filing/view/qrbox_result.php?id=";
$link_qrcode 	= $url.$hasil_encrypt."";
//-------------------------------------------------------------------------------

$sql	=	mssql_query("INSERT INTO msbox(kd_rak,
											kd_box,
											deskripsi,
											link_qrcode,
											data_status,
											input_user,
											input_date)VALUES('$kd_rak',
																'$kd_box',
																'$deskripsi',
																'$link_qrcode',
																'$data_status',
																'$input_user',
																'$input_date')");
	if($sql){
	//-------------------------------- untuk log aktifitas ------------------------------------------
	$actlog = mssql_query("INSERT INTO log_activity (activity,
													menu,
													kode,
													status,
													user_log,
													date_log)values('$activity_add',
																	'box',
																	'$kd_box',
																	'SUCCESS',
																	'$input_user',
																	convert(varchar(200),'$input_date'))");
	//-------------------------------------------------------------------------------------------------
		$url    = "mid=addbox&alert=1&kd_rak=".$kd_rak;
	}else{
		$url    = "mid=addbox&alert=2";
	}

	$urlEnc = $edc->encrypt($url,true);
	echo $urlEnc;
}

//---------------------------------------------------- UPDATE BOX ---------------------------------------
elseif($postact == 'editbox'){
	
$id_box		=	$_POST['id_box'];
$kd_rak		=	$_POST['kd_rak'];
$deskripsi  =	$_POST['deskripsi'];

$sql	=	mssql_query("
				UPDATE msbox SET kd_rak			= '$kd_rak',
								 deskripsi 		= '$deskripsi'
								WHERE id_box 	= '$id_box'
								");

	if($sql){
	$getkode = mssql_fetch_assoc(mssql_query("SELECT * FROM msbox WHERE id_box = '".$id_box."'"));
	$kd_box = $getkode['kd_box'];

	//-------------------------------- untuk log aktifitas ------------------------------------------
	$actlog = mssql_query("INSERT INTO log_activity (activity,
													menu,
													kode,
													status,
													user_log,
													date_log)values('$activity_edit',
																	'box',
																	'$kd_box',
																	'SUCCESS',
																	'$input_user',
																	convert(varchar(200),'$input_date'))");
	//-----------------------------------------------------------------------------------------------
		$url    = "mid=editbox&alert=1&id=".$id_box;
	}else{
		$url    = "mid=editbox&alert=2&id=".$id_box;
	}

	$urlEnc = $edc->encrypt($url,true);
	echo $urlEnc;
}
//---------------------------------------------------- DELETE BOX ---------------------------------------
elseif($getact == 'delbox'){

$id		=	$_GET['id'];

$getkode = mssql_fetch_assoc(mssql_query("SELECT * FROM msbox WHERE id_box = '".$id."'"));
$kd_box = $getkode['kd_box'];
$status = 'PENDING';

//-------------------------------- untuk log aktifitas ------------------------------------------
$actlog = mssql_query("INSERT INTO log_activity (activity,
												menu,
												kode,
												status,
												user_log,
												date_log)values('$activity_del',
																'box',
																'$kd_box',
																'$status',
																'$input_user',
																convert(varchar(200),'$input_date'))");
//-----------------------------------------------------------------------------------------------


$sql	=	mssql_query("DELETE FROM msbox WHERE id_box	= '".$id."'");

	if($sql){
		$stat = 'SUCCESS';
		$upstat = mssql_query("UPDATE log_activity set status = '".$stat."' where id_activity =(select top 1 id_activity from log_activity where activity ='HAPUS' and menu='box' order by id_activity desc)");
		$url = "mid=msbox&alert=1&ket=dihapus";
	}else{
		$url = "mid=msbox&alert=2&ket=dihapus";
	}

	$urlEnc = $edc->encrypt($url,true);
	header("location:../main.php?".$urlEnc."");
}

//-------------------------------------------------------------------------------------------------------------



//---------------------------------------------------- APPROVE BOX ---------------------------------------

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
