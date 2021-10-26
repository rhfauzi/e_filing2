<?php
error_reporting(0);
session_start();


function CekExist($table,$field,$isi)
{
$cek = mssql_num_rows(mssql_query("SELECT * FROM $table WHERE $field ='".$isi."'"));
return $cek;
}

function CekExist2($table,$field,$isi,$field2,$isi2)
{
$cek = mssql_num_rows(mssql_query("SELECT * FROM $table WHERE $field ='".$isi."' AND $field2 = '".$isi2."'"));
return $cek;
}

function mainque_tbarsip_scan(){

	$cheq = "SELECT mslokasi.kd_lokasi,mslokasi.lokasi,msrak.kd_rak,arsip.* from 
	arsip, msbox, msrak,mslokasi
	where mslokasi.kd_lokasi = msrak.kd_lokasi
	and msrak.kd_rak = msbox.kd_rak
	and msbox.kd_box = arsip.kd_box";

return $cheq;
}

function mainque_tbarsip(){

	// $cheq = "SELECT mslokasi.kd_lokasi,mslokasi.lokasi,msrak.kd_rak,arsip.* from 
	// arsip, msbox, msrak,mslokasi
	// where mslokasi.kd_lokasi = msrak.kd_lokasi
	// and msrak.kd_rak = msbox.kd_rak
	// and msbox.kd_box = arsip.kd_box";

	$cheq = "SELECT
	mslokasi.kd_lokasi,
	mslokasi.lokasi,
	msrak.kd_rak,
	arsip.*
	FROM
	arsip
	LEFT JOIN msbox ON arsip.kd_box = msbox.kd_box 
	LEFT JOIN msrak ON msrak.kd_rak = msbox.kd_rak 
	LEFT JOIN mslokasi ON mslokasi.kd_lokasi = msrak.kd_lokasi";

return $cheq;
}


function mainque_tbbox(){

$cheq = "SELECT mslokasi.kd_lokasi,msbox.*
		from msbox, msrak,mslokasi
		where mslokasi.kd_lokasi = msrak.kd_lokasi
		and msrak.kd_rak = msbox.kd_rak";

return $cheq;
}

function countque_tbarsip(){

$cheq = "SELECT count(*) as jumlah from 
		arsip, msbox, msrak,mslokasi
		where mslokasi.kd_lokasi = msrak.kd_lokasi
		and msrak.kd_rak = msbox.kd_rak
		and msbox.kd_box = arsip.kd_box";

return $cheq;
}

function countque_tbbox(){

$cheq = "SELECT count(*) as jumlah
		from msbox, msrak,mslokasi
		where mslokasi.kd_lokasi = msrak.kd_lokasi
		and msrak.kd_rak = msbox.kd_rak";

return $cheq;
}

?>

