<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<script>
$(document).ready(function() {

	$("#simpan").click(function(){
		var	id_rak		=	$("#id_rak").val();
		var	kd_lokasi	=	$("#kd_lokasi").val();
	
		if(kd_lokasi == '0'){
		window.alert('Mohon untuk memilih Kode Lokasi terlebih dahulu');
		$("#kd_lokasi").focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENGUPDATE DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=editrak&id_rak="+id_rak+"&kd_lokasi="+kd_lokasi,
					url: "execute/exc_master.php",
					success: function(data){
						$("#kd_lokasi").val("0");
	
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

//refresh balikan dari update rak dan dari list master rak
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
	$SqlCek	=	mssql_query("SELECT * FROM msrak WHERE id_rak = '".$getId."'");
	$show	=	mssql_fetch_assoc($SqlCek);
}

?>
<br>
<div class="panel panel-default">
<div class="panel-heading">Form Ubah Lokasi Rak
	<div style="float:right;">
		<a href='main.php?<?php echo $urlEnc; ?>'><input class="btn btn-info btn-sm" type=button value='Data Rak'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp;Master Rak <i class="fa fa-arrow-right"></i>&nbsp;Ubah </i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Rak</td>
		<td width="20%">
		<input type='hidden' id="id_rak" value="<?php echo $show['id_rak'];?>">
		<input type='text' readonly id='kd_type' class="form-control ukuran10" placeholder="Cth : R001" value="<?php echo $show['kd_rak'];?>"> 
		</td>
		<td>
		<i class="ket">&nbsp;*Kode unik terisi otomatis</i>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Kode Lokasi</td>
		<td colspan="2">
		<select id='kd_lokasi' name="kd_lokasi" class="form-control ukuran5">
		<?php
		$sqllok = mssql_query("SELECT * FROM mslokasi WHERE data_status = 'A'");
		while($reslok = mssql_fetch_assoc($sqllok)){

		if($reslok['kd_lokasi'] == $show['kd_lokasi']){
			$selected = "selected";
		}else{
			$selected ="";
		}
			echo"
				<option value='".$reslok['kd_lokasi']."' ".$selected.">".$reslok['kd_lokasi']." - ".$reslok['lokasi']."</option>
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
		        	~ Form ubah rak digunakan untuk merubah master rak Arsip apabila ada kesalahan penulisan nama (<i>Human Error)</i>. <br>
		        	~ Kode rak bertanda '<i class="ket">&nbsp;*Kode unik terisi otomatis</i>', artinya kode tersebut tidak perlu diisi karena akan otomatis terberntuk oleh system ketika user memilih lokasi dan menyimpan data.
		        	<br>
		        	~ Data yang dapat dirubah adalah data yang belum di approve atau belum dikaitkan dengan Data Arsip.<br>
		        	~ Kode rak tidak dapat dirubah, hanya lokasi rak yang dapat dirubah agar tidak terjadi kekacauan system<br>
		        	~ Jika ingin merubah kode rak karena tidak sesuai, disarankan untuk menghapus data yang sudah ada kemudian menginputnya kembali (<i>dengan catatan data tersebut masih berstatus 'NEW' atau belum di 'APPROVE'</i>.
		        </p>
		    </div>
		</div>
	</div>
