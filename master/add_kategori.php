<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

	$("#simpan").click(function(){
		var	kd_kategori		=	$("#kd_kategori").val();
		var	nm_kategori		=	$("#nm_kategori").val();


		if(nm_kategori == ''){
			window.alert('Mohon untuk mengisi nama kategori');
			$("#nm_kategori").focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){
				$.ajax({
					type: "POST",
					data: "act=addkategori&kd_kategori="+kd_kategori+"&nm_kategori="+nm_kategori,
					url: "execute/exc_master.php",
					success: function(data){
						 $("#kd_kategori").val("");
						 $("#nm_kategori").val("");	
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
$url    = "mid=mskategori";
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
			<strong>SUCCESS !</strong> Data berhasil disimpan. 
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-warning alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<strong>WARNING !</strong> mohon maaf, Nama Kategori " <?php echo "<i style='color:red'>".$isiParam2."</i>"; ?> " sudah digunakan.
		</div>
	<?php
	}elseif($isiParam1 == '3'){
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
<div class="panel-heading">Form Tambah Kategori
	<div style="float:right;">
		<a href='main.php?<?php echo $urlEnc; ?>'><input class="btn btn-info btn-sm" type=button value='Data Kategori'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Kategori<i class="fa fa-arrow-right"></i>&nbsp; Tambah Kategrori</i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Kategori</td>
		<td width="20%">
		<input type='text' id='kd_kategori'  name="kd_kategori" placeholder="Cth : ND01" readonly class="form-control ukuran10">
		</td>
		<td>
		<i class="ket">&nbsp;*Kode unik terisi otomatis</i>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Nama Kategori</td>
		<td colspan="2"><input type='text' id='nm_kategori' class="form-control ukuran5" name="nm_kategori" placeholder="Cth : Nota Dinas"></td>
	</tr>
	<tr><td height="30px" colspan="3"></td></tr>
	<tr>
		<td></td>
		<td colspan="2" align="right">
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
	        	~ Form tambah kategori digunakan untuk menambah master kategori Arsip. <br>
	        	~ Kode kategori bertanda '<i class="ket">&nbsp;*Kode unik terisi otomatis</i>', artinya kode tersebut tidak perlu diisi karena akan otomatis terbentuk oleh system ketika user mengisi nama kategori dan menyimpan data.<br>

	        </p>
	    </div>
	</div>
	</div>

