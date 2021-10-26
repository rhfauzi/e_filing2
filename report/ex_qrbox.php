<?php

include "../setting/koneksi.php";
include "../function/changeformat.php";
include "../function/encdec.php";
conDB('.','e_filing');
$edc = new encdec();

function mainque_tbbox(){

$cheq = "SELECT mslokasi.kd_lokasi,msbox.*
		from msbox, msrak,mslokasi
		where mslokasi.kd_lokasi = msrak.kd_lokasi
		and msrak.kd_rak = msbox.kd_rak";

return $cheq;
}

$func_que_box       = mainque_tbbox();


	if($kd_lokasi_p == 0){
		$flokasi = "";
	}else{
		$flokasi 	= "AND mslokasi.kd_lokasi = '".$kd_lokasi_p."'"; 
	}

	if($kd_rak_p == 0){
		$frak = "";
	}else{
		$frak 	= "AND msrak.kd_rak = '".$kd_rak_p."'"; 
	}

	$QueMain = "".$func_que_box." 
				$flokasi
				$frak";

	$sql   		= mssql_query($QueMain);

	$sql_cek 	= mssql_num_rows($sql);

if($sql_cek == nulll || $sql_cek == 0 || $sql_cek == ''){
	$url 	= "mid=paramex_qrbox";$urlEnc = $edc->encrypt($url,true);
	echo"<script type=text/javascript>alert('Data Tidak ada')window.close()</script>";
	// echo $QueMain;
}
else{
	require 'collectiontype.php';
	//echo $Que;
?>

<table>
<tr  style='background-color:#dbe7ef;padding-left:5px;color:#000000' align='center'>
		<td>No</td>
		<td>Lokasi</td>
		<td>Rak</td>
		<td>Box</td>
		<td>Link QrCode</td>
		<td>Data Status</td>
		<td>Input User</td>
		<td>Input Date</td>
		</tr>

	<?php
	$warna1 = "#EEEEEE";
	$warna2 = "#ffffff";
	$warna = "green";

	$no=1;
	while($res=mssql_fetch_assoc($sql)){
	?>	

	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $res['kd_lokasi']; ?></td>
		<td><?php echo $res['kd_rak']; ?></td>
		<td><?php echo $res['kd_box']; ?></td>
		<td><?php echo $res['link_qrcode']; ?></td>
		<td><?php echo $res['data_status']; ?></td>
		<td><?php echo $res['input_user']; ?></td>
		<td><?php echo $res['input_date']; ?></td>
	</tr>
	<?php
	$no++;

	}
	
	echo "</table>";
}
?>