<?php
date_default_timezone_set("Asia/Jakarta");
$tgl  = date("Ymd:His");
$name = $_GET['nm'];
$name_p = $_GET['nm'];


if($_GET["print"] == 1){
	$nama = $name."_".$tgl;
	header("Content-type:application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=$nama.xls"); 
    header("Pragma: no-cache");  
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
    header("Expires: 0");
}
if($_GET["print"] == 2){
	$word= $name.$tgl.".doc";
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=$word.doc"); 
	header('Cache-Control: public');
}
if($_GET["print"] == 3){
	echo"Print to HTML";
}


//----- excel for crcode -------------
if($_GET["print"] == 4){

	if($kd_uker_qr == '0'){ $nmuker = 'ALL_UKER';}else{$nmuker = "_".$kd_uker_qr;}

	$nama = $name."_".$nmuker."_".$tgl;
	header("Content-type:application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=$nama.xls"); 
    header("Pragma: no-cache");  
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
}
//-----------------------------------


if($_POST["print"] == 5){
	$nama = $name_p."_".$tgl;
	header("Content-type:application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=$nama.xls"); 
    header("Pragma: no-cache");  
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
    header("Expires: 0");
}


?>