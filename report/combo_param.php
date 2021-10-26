<?php
require '../setting/koneksi.php';
conDB('.','e_filing');

$act = $_GET['act'];

//------------------------------------------ UNTUK SELECT TYPE BERDASARKAN KATEGORI ------------------------------

if($act == 'lokrak'){

	$kd_lokasi = $_GET['kd_lokasi'];
	$showrak = mssql_query("SELECT kd_lokasi,kd_rak FROM msrak WHERE data_status = 'A' AND kd_lokasi = '".$kd_lokasi."'");
	echo "<option value='0'>ALL</option>";
	while ($resrak = mssql_fetch_array($showrak)){
		echo "<option value='".$resrak['kd_rak']."'>".$resrak['kd_rak']."</option>";
	}

}


if($act == 'rakbox'){

	$kd_rak = $_GET['kd_rak'];
	$showbox = mssql_query("SELECT kd_rak,kd_box FROM msbox WHERE data_status = 'A' AND kd_rak = '".$kd_rak."'");
	echo "<option value='0'>ALL</option>";
	while ($resbox = mssql_fetch_array($showbox)){
	echo "<option value='".$resbox['kd_box']."'>".$resbox['kd_box']."</option>";
	}
}




?>