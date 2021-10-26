<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<script>
$(document).ready(function() {

	$("#simpan").click(function(){
		var	id_type		=	$("#id_type").val();
		var	kd_kategori	=	$("#kd_kategori").val();
		var	type		=	$("#type").val();
	
		if(kd_kategori == '0'){
		window.alert('Mohon untuk memilih Kode Kategori terlebih dahulu');
		}else if(type == ''){
		window.alert('Mohon isi type');
		}else{

			if(confirm('ANDA YAKIN INGIN MENGUPDATE DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=edittype&id_type="+id_type+"&kd_kategori="+kd_kategori+"&type="+type,
					url: "execute/exc_master.php",
					success: function(data){
						$("#kd_kategori").val("");
						$("#type").val("");

						 if(data ==''){
						 	window.location = 'main.php?mid=edittype&alert=1&id='+id_type;
						 }else{
						 	window.location = 'main.php?mid=edittype&alert=2';
						 }	
						 //alert(data);
					}
				});
			}
		}
	});
});
</script>
<?php

if(!empty($_GET['id'])){
	$SqlCek	=	mssql_query("SELECT * FROM mstype WHERE id_type = '".$_GET['id']."'");
	$show	=	mssql_fetch_assoc($SqlCek);
}
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?mid=mstype'>
			<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil dirubah. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=mstype'>
			<button type="button" class="close">×</button>
		</a>
		<strong>DENIED !</strong> mohon maaf, Data gagal dirubah.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------
?>
<br>
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">Form Ubah Type
	<div style="float:right;">
			<a href='main.php?mid=mstype'><input class="btn btn-info btn-sm" type=button value='Data Type'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp;Master Type <i class="fa fa-arrow-right"></i>&nbsp;Ubah </i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Type</td>
		<td width="20%">
		<input type='hidden' id="id_type" value="<?php echo $show['id_type'];?>"> 
		<input type='text' readonly id='kd_type' class="form-control ukuran10" placeholder="Cth : TYP001" value="<?php echo $show['kd_type'];?>"> 
		</td>
		<td>
		<i class="ket">&nbsp;*Kode unik terisi otomatis</i>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Kode Kategori</td>
		<td colspan="2">
		<input type="hidden" name="id_type"	id="id_type" value="<?php echo $show[id_type]; ?>">
		<select id='kd_kategori' name="kd_kategori" readonly class="form-control ukuran5">
		<?php
		$sqlkategori = mssql_query("SELECT * FROM mskategori WHERE kd_kategori = '".$show['kd_kategori']."'");
		while($reskat = mssql_fetch_assoc($sqlkategori)){
			echo"
				<option value='".$reskat['kd_kategori']."'>".$reskat['kd_kategori']." - ".$reskat['nm_kategori']."</option>
			";
		}
		?>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Type</td>
		<td colspan="2"><input class="form-control ukuran5" type='text' id='type' name="type" placeholder="Cth : Meja" value='<?php echo $show[nm_type]; ?>'></td>
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
		        	~ Form ubah type digunakan untuk merubah master type Arsip apabila ada kesalahan penulisan nama (<i>Human Error)</i>. <br>
		        	~ Kode type bertanda '<i class="ket">&nbsp;*Kode unik terisi otomatis</i>', artinya kode tersebut tidak perlu diisi karena akan otomatis terberntuk oleh system ketika user mengisi nama type dan menyimpan data.
		        	<br>
		        	~ Data yang dapat dirubah adalah data yang belum di approve atau belum dikaitkan dengan Data Arsip.<br>
		        	~ Kode type tidak dapat dirubah, hanya nama type yang dapat dirubah agar tidak terjadi kekacauan system<br>
		        	~ Jika ingin merubah kode type karena tidak sesuai, disarankan untuk menghapus data yang sudah ada kemudian menginputnya kembali (<i>dengan catatan data tersebut masih berstatus 'NEW' atau belum di 'APPROVE'</i>.

		        </p>
		    </div>
		</div>
	</div>

</div>

