<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<script>
$(document).ready(function() {

	$("#simpan").click(function(){
		var	id_box		=	$("#id_box").val();
		var	kd_rak		=	$("#kd_rak").val();
		var	deskripsi	=	$("#deskripsi").val();

		if(kd_lokasi == '0'){
			window.alert('Mohon untuk memilih Kode Lokasi terlebih dahulu');
			$("#kd_lokasi").focus();
		}else if(kd_rak == '0'){
			window.alert('Mohon untuk memilih Kode Rak terlebih dahulu');
			$("#kd_lokasi").focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=editbox&kd_rak="+kd_rak+"&deskripsi="+deskripsi+"&id_box="+id_box,
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
	            $("#kd_rak").html(data);
	            //alert(data);
	        }
	    });
	});

});
</script>
<?php
//back to list
$url    = "mid=msbox";
$urlEnc = $edc->encrypt($url,true);
//----------------------------

///refresh balikan dari update rak dan dari list master rak
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
	$SqlCek	=	mssql_query("".$func_que_box." AND id_box = '".$getId."'");
	$show	=	mssql_fetch_assoc($SqlCek);
}

?>
<br>
<div class="panel panel-default">
<div class="panel-heading">Form Ubah Lokasi Box
	<div style="float:right;">
		<a href='main.php?<?php echo $urlEnc; ?>'><input class="btn btn-info btn-sm" type=button value='Data Box'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp;Master Box <i class="fa fa-arrow-right"></i>&nbsp;Ubah </i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Box</td>
		<td width="20%">
		<input type='hidden' id="id_box" value="<?php echo $show['id_box'];?>">
		<input type='text' id='kd_box'  name="kd_box" placeholder="Cth : B001" readonly class="form-control ukuran10" value="<?php echo $show['kd_box'];?>">
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

		if($reslok['kd_lokasi'] == $show['kd_lokasi']){
			$selected = "selected";
		}else{
			$selected = "";
		}
			echo"
				<option value='".$reslok['kd_lokasi']."' ".$selected.">".$reslok['kd_lokasi']." - ".$reslok['lokasi']."</option>
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
		<?php
		$sqlrak = mssql_query("SELECT * FROM msrak WHERE data_status = 'A' AND kd_rak = '".$show['kd_rak']."'");
		$resrak = mssql_fetch_assoc($sqlrak);
		echo"
			<option value='".$resrak['kd_rak']."' ".$selected.">".$resrak['kd_rak']."</option>
		";
		?>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td width="25%">Deskripsi</td>
		<td colspan="2">
		<textarea name='deskripsi' id='deskripsi' class='form-control'><?php echo $show['deskripsi']; ?></textarea>
		</td>
	</tr>
	<tr><td height="30px" colspan="3"></td></tr>
	<tr>
		<td></td>
		<td colspan="2" align="right">
		<!-- <input type="submit" id='simpan' class="page gradient" value="Simpan"> -->
		<button id='simpan' class="btn btn-outline btn-warning">Update</button>
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
		        	~ Form ubah box digunakan untuk merubah master box Arsip apabila ada kesalahan penulisan nama (<i>Human Error)</i>. <br>
		        	~ Kode box bertanda '<i class="ket">&nbsp;*Kode unik terisi otomatis</i>', artinya kode tersebut tidak perlu diisi karena akan otomatis terbentuk oleh system ketika user memilih lokasi, rak dan menyimpan data.
		        	<br>
		        	~ Data yang dapat dirubah adalah data yang belum di approve atau belum dikaitkan dengan Data Arsip.<br>
		        	~ Kode box tidak dapat dirubah, hanya lokasi dan rak yang dapat dirubah agar tidak terjadi kekacauan system<br>
		        	~ Jika ingin merubah kode box karena tidak sesuai, disarankan untuk menghapus data yang sudah ada kemudian menginputnya kembali (<i>dengan catatan data tersebut masih berstatus 'NEW' atau belum di 'APPROVE'</i>.
		        </p>
		    </div>
		</div>
	</div>


