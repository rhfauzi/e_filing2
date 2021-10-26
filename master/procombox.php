<?php
require '../setting/koneksi.php';
conDB('.','e_filing');

$act = $_GET['act'];


// //------------------------------------------ UNTUK SELECT TYPE BERDASARKAN KATEGORI ------------------------------

// if($act == 'type'){

// 	$kd_kategori = $_GET['kd_kategori'];
// 	$showtype = mssql_query("SELECT kd_type,type_asset FROM mstype_asset WHERE data_status = 'A' AND kd_kategori = '".$kd_kategori."'");
// 	while ($restype = mssql_fetch_array($showtype)){
// 	echo "<option value='".$restype['kd_type']."'>".$restype['kd_type']." - ".$restype['type_asset']."</option>";
// 	}
// }


// //------------------------------ UNTUK SELECT TYPE BERDASARKAN KATEGORI KHUSUS UNTUK LAPORAN --------------------

// // untuk laporan disediakan pilihan 'semua type' sedangkan untuk inputan harus memilih salah satu type

// if($act == 'type_lap'){

// 	$kd_kategori = $_GET['kd_kategori'];
// 	$showtype = mssql_query("SELECT kd_type,type_asset FROM mstype_asset WHERE data_status = 'A' AND kd_kategori = '".$kd_kategori."'");
// 	echo "<option value=0>Semua Type</option>";
// 	while ($restype = mssql_fetch_array($showtype)){
// 	echo "<option value='".$restype['kd_type']."'>".$restype['kd_type']." - ".$restype['type_asset']."</option>";
// 	}
// }

// //--------------------------------------------UNTUK SELECT LOKASI BERDASARKAN UNIT KERJA -----------------------------------------
	
// elseif($act == 'uker'){

// 	$ex_kd_uker = explode("-",$_GET['kd_uker']);
// 	$kd_uker 	 = $ex_kd_uker[0];

// 	$sqllokasi = mssql_query("SELECT * FROM mslokasi WHERE kd_uker = '".$kd_uker."' AND data_status = 'A'");
// 	while($reslok = mssql_fetch_assoc($sqllokasi)){
// 		echo"
// 			<option value='".$reslok['kd_lokasi']."'>".$reslok['kd_lokasi']." - ".$reslok['lokasi']."</option>
// 		";
// 	}
// }


// //--------------------UNTUK SELECT LOKASI BERDASARKAN UNIT KERJA KHUSUS UTNUK LAPORAN --------------------------------

// // untuk laporan disediakan pilihan 'semua lokasi' sedangkan untuk inputan harus memilih salah satu lokasi	

// elseif($act == 'uker_lap'){

// 	$ex_kd_uker = explode("-",$_GET['kd_uker']);
// 	$kd_uker 	 = $ex_kd_uker[0];

// 	$sqllokasi = mssql_query("SELECT * FROM mslokasi WHERE kd_uker = '".$kd_uker."' AND data_status = 'A'");
// 	echo "<option value=0> Semua Lokasi </option>";
// 	while($reslok = mssql_fetch_assoc($sqllokasi)){
// 		echo"
// 			<option value='".$reslok['kd_lokasi']."'>".$reslok['kd_lokasi']." - ".$reslok['lokasi']."</option>
// 		";
// 	}
// }

// //------------------------------------------ UNTUK FORM TAMBAH MUTASI --------------------------------------------
// elseif($act == 'lokasi_posisi'){

// 	$ex_kd_asset = explode("-",$_GET['kd_asset']);
// 	$kd_asset 	 = $ex_kd_asset[0];

// 	$getkode   = mssql_fetch_assoc(mssql_query("SELECT kd_lokasi FROM asset WHERE kd_asset = '".$kd_asset."'"));
// 	$kd_lokasi = $getkode['kd_lokasi'];

// 	$sqllokasi = mssql_query("SELECT * FROM $uker as z WHERE KodeUnit = '".$kd_lokasi."'");
// 	while($reslok = mssql_fetch_assoc($sqllokasi)){
// 		echo"
// 			<option value='".$reslok['KodeUnit']."'>".$reslok['KodeUnit']." - ".$reslok['UnitKerja']."</option>
// 		";
// 	}
// }


//------------------------------------------ UNTUK SELECT RAK BERDASARKAN LOKASI ------------------------------

if($act == 'lokrak'){

	$kd_lokasi = $_GET['kd_lokasi'];
	$showtype = mssql_query("SELECT kd_lokasi,kd_rak FROM msrak WHERE data_status = 'A' AND kd_lokasi = '".$kd_lokasi."'");
	echo "<option value='0'>~ Pilih Rak ~</option>";
	while ($resrak = mssql_fetch_array($showtype)){
	echo "<option value='".$resrak['kd_rak']."'>".$resrak['kd_rak']."</option>";
	}

	//echo "SELECT kd_lokasi,kd_rak FROM msrak WHERE data_status = 'A' AND kd_lokasi = '".$kd_lokasi."'";
}




?>