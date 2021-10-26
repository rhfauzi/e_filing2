<?php
$type 		= $_GET['type'];

//GET
$kd_kategori				=	$_GET['kd_kategori'];
$kd_uker 					= 	$_GET['kd_uker'];
$kd_type 					=	$_GET['kd_type'];
$kd_lokasi					=	$_GET['kd_lokasi'];
$kd_rak						=	$_GET['kd_rak'];
$kd_box						=	$_GET['kd_box'];
$tgl_awal					=	$_GET['tgl_awal'];
$tgl_akhir					=	$_GET['tgl_akhir'];

//POST
$kd_lokasi_p				=	$_POST['kd_lokasi'];
$kd_rak_p					=	$_POST['kd_rak'];
$kd_box_p					=	$_POST['kd_box'];

//untuk excel qrcode

if($type == 'exarsip'){
	include "exarsip.php";
}

if($type == 'ex_qrbox'){
	include "ex_qrbox.php";
}

if($type == 'ex_qrrak'){
	include "ex_qrrak.php";
}

if($type == 'ex_qrlok'){
	include "ex_qrlok.php";
}

if($type == 'ex_qrarsip'){
	include "ex_qrarsip.php";
}

?>
