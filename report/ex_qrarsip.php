<?php
include "../setting/koneksi.php";
include "../function/changeformat.php";
conDB('.','e_filing');

function mainque_tbarsip(){

$cheq = "SELECT mslokasi.kd_lokasi,mslokasi.lokasi,msrak.kd_rak,arsip.* from 
		arsip, msbox, msrak,mslokasi
		where mslokasi.kd_lokasi = msrak.kd_lokasi
		and msrak.kd_rak = msbox.kd_rak
		and msbox.kd_box = arsip.kd_box";

return $cheq;
}

$func_que_arsip     = mainque_tbarsip();


	if($kd_lokasi_p == '0' || $kd_lokasi_p == ''){
		$flokasi = "";
	}else{
		$flokasi 	= " AND mslokasi.kd_lokasi = '".$kd_lokasi_p."'"; 
	}

	if($kd_rak_p == '0' || $kd_rak_p == ''){
		$frak = "";
	}else{
		$frak 	= " AND msrak.kd_rak = '".$kd_rak_p."'"; 
	}

	if($kd_box_p == '0' || $kd_box_p == ''){
		$fbox = "";
	}else{
		$fbox 	= " AND msbox.kd_box = '".$kd_box_p."'"; 
	}

	$QueMain = "".$func_que_arsip."
				$flokasi
				$frak
				$fbox";

	$sql   		= mssql_query($QueMain);

	$sql_cek 	= mssql_num_rows($sql);

if($sql_cek == nulll || $sql_cek == 0 || $sql_cek == ''){
		echo"<script type=text/javascript>alert('Data Tidak ada')
				 window.close()</script>";
		//echo $QueMain;
}
else{
	require 'collectiontype.php';
	//echo $Que;

?>

<table>
<tr  style='background-color:#dbe7ef;padding-left:5px;color:#000000' align='center'>
		<td>No</td>
		<td>Kode Arsip</td>
		<td>Kategori</td>
		<td>Type</td>
		<td>Lokasi</td>
		<td>Rak</td>
		<td>Box</td>
		<td>Unit Kerja</td>
		<td>Nama Arsip</td>
		<td>Link QRCode</td>
		<td>Nomor Arsip</td>
		<td>Deskripsi</td>
		<td>Tanggal Terbit</td>
		<td>Tanggal Masuk</td>
		<td>Tanggal Input</td>
		<td>Oleh</td>
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
		<td><?php echo $res['kd_arsip']; ?></td>
		<td><?php echo "(".$res['kd_kategori'].") ".$res['nm_kategori']; ?></td>
		<td><?php echo "(".$res['kd_type'].") ".$res['nm_type']; ?></td>
		<td><?php echo $res['kd_lokasi']; ?></td>
		<td><?php echo $res['kd_rak']; ?></td>
		<td><?php echo $res['kd_box']; ?></td>
		<td><?php echo $res['kd_uker']; ?></td>
		<td><?php echo $res['nama_arsip']; ?></td>
		<td><?php echo $res['link_qrcode']; ?></td>
		<td><?php echo $res['nomor_arsip']; ?></td>
		<td><?php echo $res['deskripsi']; ?></td>
		<td style='text-align:right'><?php echo date('d/m/Y',strtotime($res['tgl_terbit'])); ?></td>
		<td style='text-align:right'><?php echo date('d/m/Y',strtotime($res['tgl_masuk'])); ?></td>
		<td style='text-align:right'>
			<?php 
				$resinput =  DateTime_explode($res['input_date']); 

				echo $resinput['tgl'];
			?>
		</td>
			<td style='text-align:right'>
			<?php 
			$que_user = mssql_fetch_assoc(mssql_query("SELECT usernamePegawai from aplikasi.dbo.user_aplikasi WHERE id_pegawai ='".$res['input_user']."'"));
			echo $que_user['usernamePegawai']; ?>
		</td>
	</tr>
	<?php
	$no++;

	}
	
	echo "</table>";
}
?>