<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<script>//Proses Input
$(document).ready(function() {

	//click submit
	$("#simpan").click(function(){
		var	id_kategori		=	$("#id_kategori").val();
		var	kd_kategori		=	$("#kd_kategori").val();
		var	nm_kategori		=	$("#nm_kategori").val();
		
		if(nm_kategori == ''){
			window.alert('Mohon untuk mengisi nama kategori');
			$("#nm_kategori").focus();
		}else{

			if(confirm('ANDA YAKIN INGIN MENGUPDATE DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=editkategori&kd_kategori="+kd_kategori+"&nm_kategori="+nm_kategori+"&id_kategori="+id_kategori,
					url: "execute/exc_master.php",
					success: function(data){
						 $("#kd_kategori").val("");
						 $("#nm_kategori").val("");


						//  if(data == nm_kategori){
						//  	window.location = 'main.php?mid=editkategori&id='+id_kategori+'&alert=3&nm_kategori='+nm_kategori;
						//  }else if(data ==''){
						//  	window.location = "main.php?mid=editkategori&alert=1&id="+id_kategori;
						//  }else{
						//  	window.location = 'main.php?mid=editkategori&alert=2';
						//  }	
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
			<strong>WARNING !</strong> mohon maaf, Nama Kategori "<?php echo "<i style='color:red'>".$isiParam3."</i>"; ?>" sudah digunakan.
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
	$SqlCek	=	mssql_query("SELECT * FROM mskategori WHERE id_kategori = '".$getId."'");
	$show			=	mssql_fetch_assoc($SqlCek);
}

?>
<br>
<div class="panel panel-default">
<div class="panel-heading">Form Ubah Kategori
	<div style="float:right;">
		<a href='main.php?<?php echo $urlEnc; ?>'><input class="btn btn-info btn-sm" type=button value='Data Kategori'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp;Master Kategori <i class="fa fa-arrow-right"></i>&nbsp;Ubah </i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Kategori</td>
		<td width="20%">
		<input type='hidden' id="id_kategori" value="<?php echo $show['id_kategori'];?>"> 
		<input type='text' readonly id='kd_kategori' class="form-control ukuran10" placeholder="Cth : KTG001" value="<?php echo $show['kd_kategori'];?>"> 
		</td>
		<td>
		<i class="ket">&nbsp;*Kode unik terisi otomatis</i>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Nama Kategori</td>
		<td colspan="2"><input type='text' id='nm_kategori' class="form-control ukuran5"  placeholder="Cth : Kendaraan" value="<?php echo $show['nm_kategori'];?>"></td>
	</tr>
	<tr><td height="30px" colspan="3"></td></tr>
	<tr>
		<td></td>
		<td colspan="2" align="right"><button id='simpan' class="btn btn-outline btn-warning ">Update</button></td>
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
		        	~ Form ubah kategori digunakan untuk merubah master kategori Arsip apabila ada kesalahan penulisan nama (<i>Human Error)</i>. <br>
		        	~ Kode kategori bertanda '<i class="ket">&nbsp;*Kode unik terisi otomatis</i>', artinya kode tersebut tidak perlu diisi karena akan otomatis terberntuk oleh system ketika user mengisi nama kategori dan menyimpan data.
		        	<br>
		        	~ Data yang dapat dirubah adalah data yang belum di approve atau belum dikaitkan dengan Data Arsip.<br>
		        	~ Kode kategori tidak dapat dirubah, hanya nama kategori yang dapat dirubah agar tidak terjadi kekacauan system<br>
		        	~ Jika ingin merubah kode kategori karena tidak sesuai, disarankan untuk menghapus data yang sudah ada kemudian menginputnya kembali (<i>dengan catatan data tersebut masih berstatus 'NEW' atau belum di 'APPROVE'</i>.

		        </p>
		    </div>
		</div>
	</div>
