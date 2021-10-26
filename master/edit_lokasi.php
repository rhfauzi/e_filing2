<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<script>//Proses Input
$(document).ready(function() {

//click submit
	$("#simpan").click(function(){
		var	id_lokasi	=	$("#id_lokasi").val();
		var	nm_lokasi	=	$("#nm_lokasi").val();
		var	alamat		=	$("#alamat").val();

		if(nm_lokasi == ''){
			alert('Mohon untuk mengisi nama lokasi');
			$("#nm_lokasi").focus();
		}else if(alamat == ''){
			alert('Mohon untuk mengisi alamat lokasi');
			$("#alamat").focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENGUPDATE DATA ?')){
			
				$.ajax({
					type: "POST",
					data: "act=editlokasi&nm_lokasi="+nm_lokasi+"&id_lokasi="+id_lokasi+"&alamat="+alamat,
					url: "execute/exc_master.php",
					success: function(data){
						 $("#kd_lokasi").val("");
						 $("#nm_lokasi").val("");
						 $("#alamat").val("");

						//  if(data ==''){
						//  	window.location = "main.php?mid=editlokasi&alert=1&id="+id_lokasi;
						//  }else if(data == nm_lokasi){
						// 	 	window.location = 'main.php?mid=editlokasi&alert=2&id='+id_lokasi+"&nm_lokasi="+nm_lokasi;
						//  }else{
						//  	window.location = 'main.php?mid=addlokasi&alert=3';
						//  }

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

//refresh balikan dari update lokasi dan dari list master lokasi
if($param1 == 'alert')
{

	//------------------------------------------- ALERT MESSAGE ------------------------------------	
	if($isiParam1 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
			<a href='main.php?<?php echo $urlEnc; ?>'>
				<button type="button" class="close">×</button>
			</a>
			<strong>SUCCESS !</strong> Data berhasil diubah. 
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-warning alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<strong>WARNING !</strong> mohon maaf, Nama Lokasi "<?php echo "<i style='color:red'>".$isiParam3."</i>"; ?>" sudah digunakan.
		</div>
	<?php
	}elseif($isiParam1 == '3'){
	?>
		<div class="alert alert-danger alert-dismissable">
			<a href='main.php?<?php echo $urlEnc; ?>'>
				<button type="button" class="close">×</button>
			</a>
			<strong>DENIED !</strong> mohon maaf, Data gagal diubah mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
	//----------------------------------------------------------------------------------------------
	
	$getId = $isiParam2;
}else{
	$getId = $isiParam1;
}

if(!empty($getId)){
	$SqlCek	=	mssql_query("SELECT * FROM mslokasi WHERE id_lokasi = '".$getId."'");
	$show	=	mssql_fetch_assoc($SqlCek);
}


?>
<br>
<div class="panel panel-default">
<div class="panel-heading">Form Ubah Lokasi
	<div style="float:right;">
	<a href='main.php?<?php echo $urlEnc; ?>'><input class='btn btn-info btn-sm' type=button value='Data Lokasi'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp;Master Lokasi <i class="fa fa-arrow-right"></i>&nbsp;Ubah </i></div><br>
<table width="100%">
	<tr>
		<td width="25%">Kode Lokasi</td>
		<td width="20%">
		<input type='hidden' id="id_lokasi" value="<?php echo $show['id_lokasi'];?>"> 
		<input type='text' id='kd_lokasi'  name="kd_lokasi" placeholder="Cth : L001" readonly class="form-control ukuran10"value="<?php echo $show['kd_lokasi'];?>">
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
			<input type='text' id='nm_lokasi' class="form-control ukuran5" name="nm_lokasi" placeholder="Cth : RUANG ARSIP 1" value="<?php echo $show['lokasi'];?>">
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Alamat</td>
		<td colspan="2"><textarea class="form-control ukuran10" id="alamat" name="alamat"><?php echo $show['alamat'];?></textarea></td>
	</tr>
	<tr><td height="30px" colspan="3"></td></tr>
	<tr>
		<td></td>
		<td colspan="2" align="right">
		<!-- <input type="submit" id='simpan' class="page gradient" value="Simpan"> -->
		<button id='simpan' class="btn btn-outline btn-warning ">Update</button>
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
		        	~ Form ubah lokasi digunakan untuk merubah master lokasi Arsip apabila ada kesalahan penulisan nama (<i>Human Error)</i>. <br>
		        	~ Kode lokasi bertanda '<i class="ket">&nbsp;*Kode unik terisi otomatis</i>', artinya kode tersebut tidak perlu diisi karena akan otomatis terberntuk oleh system ketika user mengisi nama lokasi,alamat dan menyimpan data.
		        	<br>
		        	~ Data yang dapat dirubah adalah data yang belum di approve atau belum dikaitkan dengan Data Arsip.<br>
		        	~ Kode lokasi tidak dapat dirubah, hanya nama lokasi yang dapat dirubah agar tidak terjadi kekacauan system<br>
		        	~ Jika ingin merubah kode kategori karena tidak sesuai, disarankan untuk menghapus data yang sudah ada kemudian menginputnya kembali (<i>dengan catatan data tersebut masih berstatus 'NEW' atau belum di 'APPROVE'</i>.

		        </p>
		    </div>
		</div>
	</div>

