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
//$uker  = tb_unitkerja();

	if($kd_kategori == '0'){$fkategori = ""; $ikategori = "Semua Kategori";}
	else{
	$fkategori 		= "AND a.kd_kategori = '".$kd_kategori."' "; 
	$ikategori 		= "(".$kd_kategori.")";
	}

	if($kd_uker == '0'){$fuker = ""; $iuker = "Semua uker";}
	else{
	$fuker 		= "AND a.kd_uker = '".$kd_uker."' "; 
	$iuker 		= "(".$kd_uker.")";
	}

	// if($kd_type =='0'){$ftype = ""; $itype = "Semua Type";}
	// else{
	// $ftype 		= "AND a.kd_type = '".$kd_type."' ";
	// $get_type 	= mssql_fetch_array(mssql_query("SELECT * FROM mstype WHERE kd_type = '".$kd_type."'"));
	// $itype 		= "(".$kd_type.") ".$get_type['nm_type'];}


	if($kd_lokasi == '0' || $kd_lokasi == ''){$flokasi = ""; $ilokasi ="Semua Lokasi";}
	else{
	$flokasi 	= "AND a.kd_lokasi = '".$kd_lokasi."' "; 
	$get_lokasi	= mssql_fetch_array(mssql_query("SELECT * FROM mslokasi WHERE kd_lokasi = '".$kd_lokasi."'"));
	$ilokasi 	="(".$kd_lokasi.") ".$get_lokasi['lokasi'];}


	if($kd_rak == '0' || $kd_rak == ''){$frak = ""; $irak ="Semua Rak";}
	else{
	$frak 	= "AND a.kd_rak = '".$kd_rak."'"; 
	$get_rak	= mssql_fetch_array(mssql_query("SELECT * FROM msrak WHERE kd_rak = '".$kd_rak."'"));
	$irak 	="(".$kd_rak.") ".$get_rak['rak'];}


	if($kd_box == '0' || $kd_box == ''){$fbox = ""; $ibox ="Semua box";}
	else{
	$fbox 	= "AND a.kd_box = '".$kd_box."' ";
	$get_box	= mssql_fetch_array(mssql_query("SELECT * FROM msbox WHERE kd_box = '".$kd_box."'"));
	$ibox 	="(".$kd_box.") ".$get_box['box'];}


	if($tgl_awal == ""){$ftgl_awal = ""; $itgl_awal = " - ";}
	else{$ftgl_awal = "AND a.tgl_masuk >= '".DBDate($tgl_awal)."' "; $itgl_awal = $tgl_awal;}
	if($tgl_akhir == ""){$ftgl_akhir = ""; $itgl_akhir =" - ";}
	else{$ftgl_akhir = "AND a.tgl_masuk <= '".DBDate($tgl_akhir)."' "; $itgl_akhir =$tgl_akhir;}

	$func_que_arsip 	=  mainque_tbarsip();

	$QueMain = "SELECT a.* FROM (".$func_que_arsip.") as a
				WHERE 1=1
				$fkategori
				$fuker
				$flokasi
				$frak
				$fbox
				$ftgl_awal
				$ftgl_akhir";

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
	<tr><td></td><td>Kategori</td><td>=</td><td><?php echo $ikategori; ?></td></tr>
	<tr><td></td><td>Uker</td><td>=</td><td><?php echo $iuker; ?></td></tr>
	<tr><td></td><td>Lokasi</td><td>=</td><td><?php echo $ilokasi; ?></td></tr>
	<tr><td></td><td>Rak</td><td>=</td><td><?php echo $irak; ?></td></tr>
	<tr><td></td><td>Box</td><td>=</td><td><?php echo $ibox; ?></td></tr>
	<tr><td></td><td>Dari / Lebih dari tanggal</td><td>=</td><td align="left"><?php echo $itgl_awal; ?></td></tr>
	<tr><td></td><td>Sampai / Kurang dari tanggal</td><td>=</td><td align="left"><?php echo $itgl_akhir; ?></td></tr>
</table>

<table>
<tr  style='background-color:#dbe7ef;padding-left:5px;color:#000000' align='center'>
		<td>No</td>
		<td>Kode Arsip</td>
		<td>Nomor Scan</td>
		<td>Kategori</td>
		<!-- <td>Type</td> -->
		<td>Lokasi</td>
		<td>Rak</td>
		<td>Box</td>
		<td>Unit Kerja</td>
		<td>Nama Arsip</td>
		<td>Tanggal Terbit</td>
		<td>Tanggal Masuk</td>
		<td>Tanggal Input</td>
		<td>Oleh</td>
		<td>Keterangan</td>
		</tr>

	<?php
	$warna1 = "#EEEEEE";
	$warna2 = "#ffffff";
	$warna = "green";

	$no=1;
	while($res=mssql_fetch_assoc($sql)){

	if($warna==$warna1){
	$warna=$warna2;
	$style	= "style='padding-left:100px;'";
	}else{
	$warna=$warna1;
	$style	=	"";
	}
	?>	

	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $res['kd_arsip']; ?></td>
		<td><?php echo $res['no_scan']; ?></td>
		<td><?php echo $res['kd_kategori']; ?></td>
		<!-- <td><?php //echo "(".$res['kd_type'].") ".$res['nm_type']; ?></td> -->
		<td><?php echo $res['kd_lokasi']; ?></td>
		<td><?php echo $res['kd_rak']; ?></td>
		<td><?php echo $res['kd_box']; ?></td>
		<td><?php echo $res['kd_uker']; ?></td>
		<td><?php echo $res['nama_arsip']; ?></td>
		<td style='text-align:right'><?php echo $res['tgl_terbit']; ?></td>
		<td style='text-align:right'><?php echo $res['tgl_masuk']; ?></td>
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
		<td>
			<?php 
			if($res['arsip_file'] == ''){
				echo 'File Belum Diupload';
			}else{
				echo $queimg['filename'];
			}
			?>
		</td>
	</tr>
	<?php
	$no++;

	}
	
	echo "</table>";

}
?>