<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

	$("#simpan").click(function(){
		//var	kd_lokasi		=	$("#kd_lokasi").val();
		var	nm_lokasi		=	$("#nm_lokasi").val();
		var	alamat 			=	$("#alamat").val();

		if(nm_lokasi == ''){
			alert('Mohon untuk mengisi nama lokasi');
			$("#nm_lokasi").focus();
		}else if(alamat == ''){
			alert('Mohon untuk mengisi alamat lokasi');
			$("#alamat").focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=addlokasi&nm_lokasi="+nm_lokasi+"&alamat="+alamat,
					url: "execute/exc_master.php",
					success: function(data){
						 // $("#kd_uker").val("");
						 $("#nm_lokasi").val("");
						 $("#alamat").val("");

						//  if(data ==''){
						//  	//window.location = 'main.php?mid=addlokasi&alert=1';
						// 	$url    = "mid=addlokasi&alert=1";
						//  }else if(data == nm_lokasi){
						//  	//window.location = 'main.php?mid=addlokasi&alert=2&nm_lokasi='+nm_lokasi;
						// 	$url    = "mid=addlokasi&alert=2&nm_lokasi='"+nm_lokasi;
						//  }else{
						//  	//window.location = 'main.php?mid=addlokasi&alert=3';
						// 	$url    = "mid=addlokasi&alert=3";
						//  }	

						 //$urlEnc = $edc->encrypt($url,true);
						 window.location = 'main.php?'+data;

						 //alert(data);
					}
				});
			}
		}
	});
});
</script>
<?php
//back to list
$url    = "mid=mslokasi";
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
			<strong>WARNING !</strong> mohon maaf, Nama Lokasi " <?php echo "<i style='color:red'>".$isiParam2."</i>"; ?> " sudah digunakan.
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
<div class="panel-heading">Form Tambah Lokasi
	<div style="float:right;">
		<a href='main.php?<?php echo $urlEnc; ?>'><input class='btn btn-info btn-sm' type=button value='Data Lokasi'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Lokasi <i class="fa fa-arrow-right"></i>&nbsp; Tambah Lokasi</i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Lokasi</td>
		<td width="20%">
		<input type='text' id='kd_lokasi'  name="kd_lokasi" placeholder="Cth : L001" readonly class="form-control ukuran10">
		</td>
		<td>
		<i class="ket">&nbsp;*Kode unik terisi otomatis</i>
		</td>
	</tr>
	<tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Nama Lokasi</td>
		<td colspan="2">
			<input type='text' id='nm_lokasi' class="form-control ukuran5" name="nm_lokasi" placeholder="Cth : RUANG ARSIP 1">
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Alamat</td>
		<td colspan="2"><textarea class="form-control ukuran10" id="alamat" name="alamat"></textarea></td>
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
	        	~ Form tambah lokai digunakan untuk menambah master lokasi Arsip. <br>
	        	~ Kode kategori bertanda '<i class="ket">&nbsp;*Kode unik terisi otomatis</i>', artinya kode tersebut tidak perlu diisi karena akan otomatis terbentuk oleh system ketika user mengisi nama lokasi,alamat dan menyimpan data.<br>
	        </p>
	    </div>
	</div>
	</div>

