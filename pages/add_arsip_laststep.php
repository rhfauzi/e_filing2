<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 


<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

//-------------------------------- TANGGAL -----------------------------
	var year = (new Date()).getFullYear() + 10

	$("#tgl_terbit").datepicker({
		// dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,minDate: -30 
		dateFormat : "dd/mm/yy",
		changeMonth : true,
		changeYear  : true,
		yearRange	: '1980:' + year,
		numberOfMonths : 2,
		maxDate 	: 0

	});

	$("#tgl_masuk").datepicker({
		dateFormat : "dd/mm/yy",
		changeMonth : true,
		changeYear  : false,
		viewMode: "months", 
		yearRange	: '1980:' + year,
		//maxDate 	: 0

	}).focus(function () {
    $(".ui-datepicker-year").hide();
	});

//--------------------------------------------------------------------


//--------------------COMBO BOX CHANGE VALUE----------------------------

	// $("#kd_kategori").change(function(){
	//     var kd_kategori = $("#kd_kategori").val();
	//     $.ajax({
	//         url: "pages/procombox.php?act=type",
	//         data: "kd_kategori=" + kd_kategori,
	//         success: function(data){
	//             // jika data sukses diambil dari server, tampilkan di <select id=kota>
	//             $("#kd_type").html(data);
	//             //alert(data);
	//         }
	//     });
	// });

});//end jquery document
</script>

<!-- validasi form -->
<script type="text/javascript">
function validate(form)
{
	if(form.kd_kategori.value=="0" || form.kd_kategori.value== null){alert("Mohon Pilih Kategori !");form.kd_kategori.focus();return(false);}
	if(form.kd_uker.value=="0" || form.kd_uker.value== null){alert("Mohon Pilih Unit Kerja !");form.kd_uker.focus();return(false);}
	if(form.nama_arsip.value=="" || form.nama_arsip.value== null){alert("Mohon Isi Nama Arsip !");form.nama_arsip.focus();return(false);}
	if(form.deskripsi.value=="" || form.deskripsi.value== null){alert("Mohon Isi Deskripsi !");form.deskripsi.focus();return(false);}
	if(form.deskripsi.value=="" || form.deskripsi.value== null){alert("Mohon Isi Deskripsi !");form.deskripsi.focus();return(false);}

	if(form.tgl_terbit.value=="" || form.tgl_terbit.value== null || form.tgl_terbit.value== '//'){alert("Mohon Isi Tanggal Terbit!");form.tgl_terbit.focus();return(false);}
	if(form.tgl_masuk.value=="" || form.tgl_masuk.value== null || form.tgl_masuk.value== '//'){alert("Mohon Isi Tanggal Masuk!");form.tgl_masuk.focus();return(false);}
	if(form.shadow_arsip.value == ""){
		if(form.berkas.value=="" || form.berkas.value== null){alert("Mohon Upload File !");form.berkas.focus();return(false);}
	}
	
	if(form.tags.value=="" || form.tags.value== null){alert("Mohon Isi Tags Pencarian !");form.tags.focus();return(false);}
}

</script>
<!-- ==========================================================================================================-->
<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?mid=listarsip'>
			<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?mid=listarsip'>
			<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil diupdate. 
	</div>
<?php
}elseif($_GET['alert'] == '3'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=listarsip'>
			<button type="button" class="close">×</button>
		</a>
		<strong>DENIED !</strong> mohon maaf, Data gagal disimpan.
	</div>
<?php
}elseif($_GET['alert'] == '4'){
?>
	<div class="alert alert-warning alert-dismissable">
		<a href='main.php?mid=listarsip'>
			<button type="button" class="close">×</button>
		</a>
		<strong>DENIED !</strong> Type File upload hanya berupa PDF
	</div>
<?php
}
//----------------------------------------------------------------------------------------------

$id_arsip = $_GET['id_arsip'];

if($id_arsip == ''){

	$kd_arsip 		= '';

	$kd_kategori 	= "<option value='0'>~ Pilih Kategori ~</option>";
	// $kd_type 		= "<option value='0'>~ Pilih Type ~</option>";
	$kd_uker 		= "<option value='0'>~ Pilih Uker ~</option>";

	$kd_lokasi 		= $_GET['kd_lokasi'];
	$kd_rak 		= $_GET['kd_rak'];
	$kd_box 		= $_GET['kd_box'];

	$nama_arsip 	= '';
	$nomor_arsip	= '';
	$deskripsi 		= '';

	$tgl_terbit 	= '';
	$tgl_masuk 		= '';

	$arsip_file 	= '';
	$tags 			= '';
	$no_scan 		= '';

	$readonly 		= '';
	$disabled 		= '';

	$form_title 	= "Form Tambah Arsip (<i><b>step 3</b></i>)";
	$button 		= "<button id='simpan' class='btn btn-outline btn-primary' style='padding-left:100px;padding-right:100px;'>Simpan</button>";
}else{
	$getrow = mssql_fetch_assoc(mssql_query("".$func_que_arsip." AND arsip.id_arsip = '".$id_arsip."'"));

	$kd_arsip 		= $getrow['kd_arsip'];

	$kd_kategori 	= "<option value='".$getrow['kd_kategori']."'>".$getrow['kd_kategori']."</option>";
	// $kd_type 		= "<option value='".$getrow['kd_type']."'>".$getrow['kd_type']."</option>";
	$kd_uker 		= "<option value='".$getrow['kd_uker']."'>".$getrow['kd_uker']."</option>";

	$kd_lokasi 		= $getrow['kd_lokasi'];
	$kd_rak 		= $getrow['kd_rak'];
	$kd_box 		= $getrow['kd_box'];

	$nama_arsip 	= $getrow['nama_arsip'];
	$deskripsi 		= $getrow['deskripsi'];

	$tgl_terbit 	= $getrow['tgl_terbit'];
	$tgl_masuk 		= $getrow['tgl_masuk'];

	$arsip_file 	= "<i style='color:blue;'>".$getrow['arsip_file']. "</i>&nbsp;<img src='images/pdf_file.png' width='50px' height='55px'>";
	$tags 			= $getrow['tags'];
	$no_scan		= $getrow['no_scan'];

	$readonly 		= 'readonly=readonly';
	$disabled 		= 'disabled=disabled';

	$form_title 	= "Form Edit Arsip";
	$button 		= "<button id='simpan' class='btn btn-outline btn-warning' style='padding-left:100px;padding-right:100px;'>Update</button>";
}

?>
<br>
<div class="panel panel-default">
<div class="panel-heading"><?php echo $form_title; ?>
	<div style="float:right;">
			<a href='main.php?mid=listarsip'><input class="btn btn-info btn-sm" type=button value='Data Arsip'></a>
			<input class="btn btn-info btn-sm" type=button value='Kembali' onclick="window.history.back(-1)">
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Tambah Arsip</i></div><br>
<form name='form' action="execute/exc_program.php?act=addarsip" method="POST" enctype='multipart/form-data'  onsubmit="return validate(this)">
<table width="100%" border="0px">
	<tr>
		<td colspan="5">
			<input type="hidden" name="kd_lokasi" id="kd_lokasi" value="<?php echo $kd_lokasi; ?>">
			<input type="hidden" name="kd_rak" id="kd_rak" value="<?php echo $kd_rak; ?>">
			<input type="hidden" name="kd_box" id="kd_box" value="<?php echo $kd_box; ?>">
			<input type="hidden" name="id_arsip" id="id_arsip" value="<?php echo $id_arsip; ?>">
		</td>
	</tr>
	<tr>
		<td width="12%">Kode Arsip</td>
		<td width="20%">
		<input type='text' id='kd_arsip'  name="kd_arsip" placeholder="Cth : A001" readonly class="form-control ukuran8" value="<?php echo $kd_arsip; ?>"> <i class="ket">
		</td>
		<td colspan="4">
		<i class="ket">&nbsp;*Kode unik terisi otomatis</i>
		</td>
		<td rowspan="9" style="vertical-align: top;">
		<!-- tampilan keterangan gambar lokasi rak dan box -->
		<div style="padding-left: 20px;margin-bottom: 10px"><i class="ket">Lokasi yang dipilih untuk menyimpan arsip </i></div>
			<div class="col-lg-12 col-md-6">
					<div class="panel panel-softblue">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3">
					                <i class="fa fa-tasks fa-5x"></i>
					            </div>
					            <div class="col-xs-9 text-right">
					            	<div class="col-lg-12 col-md-6">
										<div class="panel panel-orangetwo">
										    <div class="panel-heading">
										        <div class="row">
										            <div class="col-xs-3">
										                <i class="fa fa-archive fa-2x"></i>
										            </div>
										            <div class="col-xs-9 text-right">
										            	
										            </div>
										        </div>
										    </div>
										    <div class="panel-footer">
										        <div class="row">
												    <div class="col-xs-12 text-left">
												            <div style="color:#999;"><b>Box No. <?php echo $kd_box; ?></b></div>
												    </div>
												</div>
											</div>
										</div>
									</div>
					            </div>
					        </div>
					    </div>
					    <div class="panel-footer">
					        <div class="row">
					        	<div class="col-xs-12 text-left">
					                <div style="color: #999;"><b>Lokasi <?php echo $kd_lokasi." / Rak No. ".$kd_rak; ?></b></div>
					            </div>
					        </div>
		    			</div>
					</div>
				</div>
		<!-- ==============================================-->
		</td>
	</tr>
	<tr><td height='5px' colspan="5"></td></tr>
	<tr>
		<td>Unit Kerja</td>
		<td>
		<select id='kd_uker' name="kd_uker" class="form-control ukuran9" <?php echo $disabled;?>>
		<?php 
		echo $kd_uker; 
			$queUker = mssql_query("SELECT * FROM ".linkSDM()."MUnitKerja");
			while($resUker = mssql_fetch_assoc($queUker)){
				echo "<option value='".$resUker['KodeUnit']."'>".$resUker['UnitKerja']."</option>";
			}
		?>	
		</select>
		</td>
		<td width="10%" align="right" style="padding-right: 10px;">Kategori</td>
		<td colspan="3" align="right">
		<select id='kd_kategori' name="kd_kategori" class="form-control ukuran9" <?php echo $disabled;?>>
		<?php
			echo $kd_kategori;
			$sql_kat = mssql_query("SELECT * FROM mskategori WHERE data_status = 'A'");
			while($res_kat = mssql_fetch_assoc($sql_kat)){
				echo "<option value=".$res_kat['kd_kategori'].">".$res_kat['kd_kategori']."-".$res_kat['nm_kategori']."</option>";
			}
		?>
		</select>
		</td>
	</tr>
	<!-- <tr><td colspan="4"></td></tr> -->
	<!-- <tr>
		<td>Type</td>
		<td colspan="3">
		<select id='kd_type' name="kd_type" class="form-control ukuran8" <?php //echo $disabled;?>>
		<?php //echo $kd_type; ?>
		</select>
		</td>
	</tr> -->
	<tr><td height='5px' colspan="5"></td></tr>
	<tr>
		<td>Nama Arsip</td>
		<td colspan="3">
		<input type='text' id='nama_arsip'  name="nama_arsip" class="form-control ukuran10" value="<?php echo $nama_arsip; ?>">
		</td>
	</tr>
	<tr><td height='5px' colspan="5"></td></tr>
	<tr>
		<td>Deskripsi</td>
		<td colspan="3">
		<textarea name="deskripsi" id="deskripsi" class="form-control ukuran10"><?php echo $deskripsi; ?></textarea>
		</td>
	</tr>
	<tr><td height='5px' colspan="5"></td></tr>
	<tr>
		<td>Tanggal Terbit</td>
		<td>
		<div class="form-group input-group ukuran7">
		<span class="input-group-addon"><i class="fa fa-calendar-o"></i>
        </span>
		<input type='text' id='tgl_terbit' name="tgl_terbit" placeholder="dd/mm/yyyy" readonly class="form-control ukuran8" style="background-color: #fff8bc;cursor: text;" value="<?php echo ShortDate($tgl_terbit); ?>">
		</div>
		</td>
		<td width="15%" align="right" style="padding-right: 10px;">Tanggal Masuk</td>
		<td colspan="2" align="right">
		<div class="form-group input-group ukuran7">
		<span class="input-group-addon"><i class="fa fa-calendar-o"></i>
        </span>
		<input type='text' id='tgl_masuk' name="tgl_masuk" placeholder="dd/mm/yyyy" readonly class="form-control ukuran3" style="background-color: #fff8bc;cursor: text;" value="<?php echo ShortDate($tgl_masuk); ?>">
		</div>
		</td>
	</tr>
	<tr><td height='5px' colspan="7"></td></tr>
	<!-- <tr>
		<td>Upload Arsip</td>
		<td colspan="7">
		<input type='file' accept='application/pdf' name='berkas' id="berkas">
		<?php //echo $arsip_file; ?>
			<input type='hidden' name='shadow_arsip' id='shadow_arsip' value="<?php //echo $getrow[arsip_file]; ?>">
		</td>
	</tr> -->
	<tr><td height='5px' colspan="7"></td></tr>
	<tr>
		<td width="15%">No Scan</td>
		<td colspan="7">
		<input type='text' id='tags'  name="no_scan" class="form-control ukuran3" placeholder='Nomor ID ketika scan document' value="<?php echo $no_scan; ?>">
		</td>
	</tr>
	<tr><td height='5px' colspan="7"></td></tr>
	<tr>
		<td width="15%">Tags Pencarian</td>
		<td colspan="7">
		<input type='text' id='tags'  name="tags" class="form-control ukuran10" placeholder='cth : buku panduan, aplikasi, portal, tsi (pisahkan dengan koma)' value="<?php echo $tags; ?>">
		</td>
	</tr>
	<tr><td height='10px' colspan="7"></td></tr>
	<tr>
		<td colspan="7" align="right">
		<!-- <input type="submit" id='simpan' class="page gradient" value="Simpan"> -->
		<!-- <button id='simpan' class="btn btn-outline btn-primary">Simpan</button> -->
		<?php echo $button; ?>
		</td>
	</tr>
</table>
</form>
<br>
</div>
</div>
</div>
</div>

	<div class="col-lg-13">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body" align="justify">
	        <p style="font-size:12px">
	        	~ <b>Perhatikan </b> Lokasi ,Rak dan Box yang dipilih untuk menyimpan arsip yang ditandai dengan kotak besar warna biru dan orange yang terletak di pojok kanan atas form.<br>
	        	~ <b>Kode Arsip</b> tidak perlu diisi karena akan terisi otomatis oleh sistem.<br>
	        	~ Pilih <b>Kategori</b> terlebih dahulu pada combobox kategori untuk memunculkan <b>Type</b> pada combobox dibawahnya.<br>
	        	~ Pilih <b>Type</b> setelah memlih kategori karena <b>Type</b> merupakan turunan dari kategori. Artinya pilihan <b>Type</b> akan muncul setelah <b>Kategori</b> dipilih dan pilihan <b>Type</b> tidak akan muncul jika kategori belum dipilih.<br>
	        	~ Kemudian pilih <b>Unit Kerja</b>, isi <b>Nama Arsip, Nomor Arsip </b> dan <b> Deskripsi</b><br>
	        	~ Masukin <b>Tanggal Terbit</b> dan <b>Tanggal Masuk</b> dengan memilih tanggal pada kalender yang muncul ketika textbox tanggal dipilih.
	        </p>
	    </div>
	</div>
	</div>


