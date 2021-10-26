<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {


	//var year 			= (new Date()).getFullYear() + 10;

	$("#tgl_ambil").datepicker({
		// dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,minDate: -30 
		dateFormat : "dd/mm/yy",
		changeMonth : true,
		//changeYear  : true,
		minDate:"-31d",
		maxDate:0,
		//yearRange	: '1900:' + year

	});

	var data = $('#tgl_ambil').val();
	var arr = data.split('/');	 

	$("#tgl_kembali").datepicker({
		// dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,minDate: -30 
		dateFormat : "dd/mm/yy",
		changeMonth : true,
		//changeYear  : true,
		//yearRange	: '1900:' + year,
		minDate		: new Date(arr[2],arr[1]-1,arr[0]),
		maxDate 	: 0

	});

});//end jquery document
</script>

<!-- validasi form -->
<script type="text/javascript">
function validate(form)
{
	if(form.nama_pengambil.value=="" || form.nama_pengambil.value== null){alert("Mohon Isi Nama Pengambil !");form.nama_pengambil.focus();return(false);}
	if(form.keperluan.value=="" || form.keperluan.value== null){alert("Mohon Isi Keperluan !");form.keperluan.focus();return(false);}

	if(form.tgl_ambil.value=="" || form.tgl_ambil.value== null || form.tgl_ambil.value== '//'){alert("Mohon Isi Tanggal Ambil!");form.tgl_ambil.focus();return(false);}
}

</script>
<!-- ==========================================================================================================-->

<br>

<div class="panel panel-default">
<div class="panel-heading">Form Pengambilan Arsip
	<div style="float:right;">
	<?php
	$url1     = "mid=listarsip";
	$urlEnc1  = $edc->encrypt($url1,true);
	?>
		<a href='main.php?<?php echo $urlEnc1; ?>'><input class="btn btn-info btn-sm" type=button value='Data Arsip'></a>
		<input class="btn btn-info btn-sm" type=button value='Kembali' onclick="window.history.back()">
	</div>
</div>
<div class="panel-body">

<div><i class="ketmenu">Daftar Arsip <i class="fa fa-arrow-right"></i>&nbsp; Detail &nbsp;<i class="fa fa-arrow-right"></i>&nbsp; Pengambilan</i></div>
<br>
<div class="row">
<div class="col-lg-6">

<?php
$key  				= $isiParam1;
$id_pengambilan  	= $isiParam2;

$info 		= mssql_fetch_assoc(mssql_query("".$func_que_arsip." AND arsip.kd_arsip = '".$key."'"));
$info_kat 	= mssql_fetch_assoc(mssql_query("SELECT * from mskategori where kd_kategori = '".$info['kd_kategori']."'"));

$info_histori = mssql_fetch_assoc(mssql_query("SELECT top 1 * FROM pengambilan WHERE kd_arsip = '".$key."' order by id_pengambilan desc"));

if($id_pengambilan == ""){
	$kd_arsip 			= $key;
	$nama_pengambil		= "";
	$keperluan 			= "";
	$tgl_ambil 			= "";
	$able_new			= "";
	$able_edit 			= " disabled";
	$style_tgl_new	 	= " style='background-color: #fff8bc;cursor: text'";
	$style_tgl_edit	 	= "";
	$button 			= "<button class='btn btn-outline btn-primary' style='padding-left:100px;padding-right:100px;'>Simpan</button>";
}else{
	$kd_arsip 			= $key;
	$nama_pengambil		= $info_histori['nama_pengambil'];
	$keperluan 			= $info_histori['keperluan'];
	$tgl_ambil			= ShortDate($info_histori['tgl_ambil']);
	$able_new			= " disabled";
	$able_edit 			= "";
	$style_tgl_new	 	= "";
	$style_tgl_edit	 	= " style='background-color: #fff8bc;cursor: text'";
	$button  			= "<button class='btn btn-outline btn-warning' style='padding-left:100px;padding-right:100px;'>Update</button>";
}

?>

<table class="table table-hover" border="0px" width="50%" style="font-size: 12px">                           
    <tbody>
        <tr>
            <td width="15%"><b style="color:#707070;">Kode Arsip</b></td>
            <td width="50%"><?php echo $kd_arsip; ?></td>
         </tr>
         <tr>
            <td width="15%"><b style="color:#707070;">Lokasi</b></td>
            <td width="50%"><?php echo $info['kd_lokasi']; ?></td>
        </tr>
         <tr>
            <td width="15%"><b style="color:#707070;">Rak</b></td>
            <td width="50%"><?php echo $info['kd_rak']; ?></td>
        </tr>
         <tr>
            <td width="15%"><b style="color:#707070;">Box</b></td>
            <td width="50%"><?php echo $info['kd_box'];; ?></td>
        </tr>
         <tr>
            <td width="15%"><b style="color:#707070;">Kategori</b></td>
            <td width="50%"><?php echo $info_kat['nm_kategori']; ?></td>
         </tr>
        
         <tr>
            <td width="15%"><b style="color:#707070;">Nama Arsip</b></td>
            <td width="50%"><?php echo $info['nama_arsip']; ?></td>
         </tr>
         <tr>
             <td width="15%"><b style="color:#707070;">Tanggal Terbit</b></td>
            <td width="50%"><?php echo ShortDate($info['tgl_terbit']); ?></td>
        </tr>
         <tr>
             <td width="15%"><b style="color:#707070;">Tanggal Masuk</b></td>
            <td width="50%"><?php echo ShortDate($info['tgl_masuk']); ?></td>
        </tr>
    </tbody>
</table>

</div>
<div class="col-lg-6">
<form name='form' action="execute/exc_program.php?act=ambilarsip" method="POST" enctype='multipart/form-data'  onsubmit="return validate(this)">
<table width="100%" border="0px">
	<input type='hidden' id='kd_arsip' name="kd_arsip" class="form-control ukuran5" value="<?php echo $kd_arsip; ?>">
	<input type='hidden' id='id_pengambilan'  name="id_pengambilan" class="form-control ukuran1" value="<?php echo $id_pengambilan; ?>">
	<tr><td height='5px' colspan="5"></td></tr>
	<tr>
		<td width="20%">Nama Pengambil</td>
		<td width="50%">
		<input type='text' id='nama_pengambil'  name="nama_pengambil" class="form-control ukuran10" <?php echo $able_new;?> value="<?php echo $nama_pengambil; ?>">
		</td>
	</tr>
	<tr><td height='5px' colspan="5"></td></tr>
	<tr>
		<td width="20%">Keperluan</td>
		<td width="50%">
		<textarea name="keperluan" id="keperluan" class="form-control ukuran10" rows="4" <?php echo $able_new;?>><?php echo $keperluan; ?></textarea>
		</td>
	</tr>
	<tr><td height='10px' colspan="5"></td></tr>
	<tr>
		<td width="20%">Tanggal Ambil</td>
		<td width="50%">
		<div class="form-group input-group ukuran4">
		<span class="input-group-addon"><i class="fa fa-calendar-o"></i>
        </span>
		<input type='text' id='tgl_ambil' name="tgl_ambil" placeholder="dd/mm/yyyy" readonly class="form-control ukuran3" <?php echo $able_new." ".$style_tgl_new; ?> value="<?php echo $tgl_ambil; ?>">
		</div>
		</td>
	</tr>
	<tr><td height='5px' colspan="5"></td></tr>
	<tr>
		<td width="20%">Tanggal Kembali</td>
		<td width="50%">
		<div class="form-group input-group ukuran4">
		<span class="input-group-addon"><i class="fa fa-calendar-o"></i>
        </span>
		<input type='text' id='tgl_kembali' name="tgl_kembali" placeholder="dd/mm/yyyy" class="form-control ukuran3" <?php echo $able_edit." ".$style_tgl_edit; ?>>
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
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
	        	~ Form Pengambilan arsip digunakan jika ada pekerja yang ingin mengambil hardcopy arsip tertentu pada ruang arsip, isi dahulu form ini sebelum mengambil arsip.<br>
	        	~ Isi nama pekerja yang ingin mengambil hardcopy arsip pada kolom nama pengambil.<br>
	        	~ Isi tujuan pegambilan pada kolom keperluan.<br>
	        	~ Isi tanggal pengambilan pada kolom tanggal.<br>
	        	~ Untuk tanggal pengembalian diisi ketika hardcopy sudah dikembalikan oleh si pekerja yang meminjam hardcopy arsip tersebut.<br>
	        </p>
	    </div>
	</div>
	</div>


