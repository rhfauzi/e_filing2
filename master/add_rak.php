<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

	$("#simpan").click(function(){
		var	kd_lokasi		=	$("#kd_lokasi").val();

		if(kd_lokasi == '0'){
			window.alert('Mohon untuk memilih Kode Lokasi terlebih dahulu');
			$("#kd_lokasi").focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=addrak&kd_lokasi="+kd_lokasi,
					url: "execute/exc_master.php",
					success: function(data){
						 $("#kd_lokasi").val("");

						 window.location = 'main.php?'+data;
					}
				});
			}
		}
	});
});
</script>
<?php
//back to list
$url    = "mid=msrak";
$urlEnc = $edc->encrypt($url,true);
//----------------------------


//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($param1 == 'alert')
{	
	if($isiParam1 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
			<a href='main.php?<?php echo $urlEnc; ?>'>
				<button type="button" class="close">×</button>
			</a>
			<?php 
			$get_kd_lokasi = $isiParam2;
			$Que = mssql_fetch_assoc(mssql_query("SELECT top 1 * FROM msrak WHERE kd_lokasi = '".$get_kd_lokasi."' ORDER by id_rak desc"));
			?>
			<strong>SUCCESS !</strong> Data berhasil disimpan. 
			<?php echo "Data baru dengan nomor Rak <b>".$Que['kd_rak']."</b> pada Lokasi <b>".$Que['kd_lokasi']."</b> telah ditambahkan"; ?>
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
			<a href='main.php?<?php echo $urlEnc; ?>'>
				<button type="button" class="close">×</button>
			</a>
			<strong>DENIED !</strong> mohon maaf, Data gagal disimpan mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------
?>
<br>
<div class="panel panel-default">
<div class="panel-heading">Form Tambah Rak
	<div style="float:right;">
		<a href='main.php?<?php echo $urlEnc; ?>'><input class="btn btn-info btn-sm" type=button value='Data Rak'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Rak <i class="fa fa-arrow-right"></i>&nbsp; Tambah Rak</i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Rak</td>
		<td width="20%">
		<input type='text' id='kd_rak'  name="kd_rak" placeholder="Cth : R001" readonly class="form-control ukuran10">
		</td>
		<td>
		<i class="ket">&nbsp;*Kode unik terisi otomatis</i>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td width="25%">Kode Lokasi</td>
		<td colspan="2">
		<select id='kd_lokasi' name="kd_lokasi" class="form-control ukuran5">
		<option value='0'>~ Pilih Lokasi ~</option>
		<?php
		$sqllokasi = mssql_query("SELECT * FROM mslokasi WHERE data_status = 'A'");
		while($reslok = mssql_fetch_assoc($sqllokasi)){
			echo"
				<option value='".$reslok['kd_lokasi']."'>".$reslok['kd_lokasi']." - ".$reslok['lokasi']."</option>
			";
		}
		?>
		</select>
		</td>
	</tr>
	<tr><td height="30px" colspan="3"></td></tr>
	<tr>
		<td></td>
		<td colspan="2" align="right">
		<!-- <input type="submit" id='simpan' class="page gradient" value="Simpan"> -->
		<button id='simpan' class="btn btn-outline btn-primary">Simpan</button>
		</td>
	</tr>
</table>
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
	    <div class="panel-body">
	        <p style="font-size:12px">
	        	~ Form tambah rak digunakan untuk menambah master rak Arsip. <br>
	        	~ Kode rak bertanda '<i class="ket">&nbsp;*Kode unik terisi otomatis</i>', artinya kode tersebut tidak perlu diisi karena akan otomatis terbentuk oleh system ketika user memilih lokasi dan menyimpan data.<br>
	        	~ Pilih Lokasi untuk menentukan dimana lokasi rak berada.
	        </p>
	    </div>
	</div>
	</div>

