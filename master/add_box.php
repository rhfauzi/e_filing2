<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

$('#kd_rak').attr("disabled",true);

	$("#simpan").click(function(){
		var	kd_lokasi	=	$("#kd_lokasi").val();
		var	kd_rak		=	$("#kd_rak").val();
		var	deskripsi	=	$("#deskripsi").val();

		if(kd_lokasi == '0'){
			window.alert('Mohon untuk memilih Kode Lokasi terlebih dahulu');
			$("#kd_lokasi").focus();
		}else if(kd_rak == '0'){
			window.alert('Mohon untuk memilih Kode Rak terlebih dahulu');
			$("#kd_rak").focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=addbox&kd_rak="+kd_rak+"&deskripsi="+deskripsi,
					url: "execute/exc_master.php",
					success: function(data){
						 $("#kd_rak").val("0");
						window.location = 'main.php?'+data;
					}
				});
			}
		}
	});



//--------------------COMBO BOX CHANGE VALUE----------------------------

	$("#kd_lokasi").change(function(){
	    var kd_lokasi = $("#kd_lokasi").val();
	    $.ajax({
	        url: "master/procombox.php?act=lokrak",
	        data: "kd_lokasi=" + kd_lokasi,
	        success: function(data){
	            // jika data sukses diambil dari server, tampilkan di <select id=kota>
	            $('#kd_rak').attr("disabled",false);
	            $("#kd_rak").html(data);
	            //alert(data);
	        }
	    });
	});

});//end jquery document
</script>
<?php
//back to list
$url    = "mid=msbox";
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
			$get_kd_rak 	= $isiParam2;
			$Que = mssql_fetch_assoc(mssql_query("SELECT top 1 * FROM msbox WHERE kd_rak = '".$get_kd_rak."' ORDER by id_box desc"));
			?>
			<strong>SUCCESS !</strong> Data berhasil disimpan. 
			<?php echo "Data baru dengan nomor Box <b>".$Que['kd_box']."</b> pada Rak <b>".$Que['kd_rak']."</b> telah ditambahkan"; ?>
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
			<a href='main.php?<?php echo $urlEnc; ?>'>
				<button type="button" class="close">×</button>
			</a>
			<strong>DENIED !</strong> mohon maaf, Data gagal disimpan ungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------
?>
<br>
<div class="panel panel-default">
<div class="panel-heading">Form Tambah Box
	<div style="float:right;">
			<a href='main.php?<?php echo $urlEnc; ?>'><input class="btn btn-info btn-sm" type=button value='Data Box'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Box <i class="fa fa-arrow-right"></i>&nbsp; Tambah Box</i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Box</td>
		<td width="20%">
		<input type='text' id='kd_box'  name="kd_box" placeholder="Cth : B001" readonly class="form-control ukuran10">
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
		$sqllok = mssql_query("SELECT * FROM mslokasi WHERE data_status = 'A'");
		while($reslok = mssql_fetch_assoc($sqllok)){
			echo"
				<option value='".$reslok['kd_lokasi']."'>".$reslok['kd_lokasi']." - ".$reslok['lokasi']."</option>
			";
		}
		?>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td width="25%">Kode Rak</td>
		<td colspan="2">
		<select id='kd_rak' name="kd_rak" class="form-control ukuran5">
		<option value='0'>~ Pilih Rak ~</option>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td width="25%">Deskripsi</td>
		<td colspan="2">
		<textarea name='deskripsi' id='deskripsi' class='form-control'></textarea>
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
	        	~ Pilih Lokasi dan rak untuk menentukan dimana lokasi box berada.
	        </p>
	    </div>
	</div>
	</div>

