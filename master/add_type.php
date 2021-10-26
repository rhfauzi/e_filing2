<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

	$("#simpan").click(function(){
		var	kd_kategori		=	$("#kd_kategori").val();
		var	type 			=	$("#type").val();

		if(kd_kategori == '0'){
			window.alert('Mohon untuk memilih Kode Kategori terlebih dahulu');
		}else if(type == ''){
			window.alert('Mohon isi type');
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=addtype&kd_kategori="+kd_kategori+"&type="+type,
					url: "execute/exc_master.php",
					success: function(data){
						 $("#kd_kategori").val("");
						 $("#type").val("");

						 if(data ==''){
						 	window.location = 'main.php?mid=addtype&alert=1';
						 }else{
						 	window.location = 'main.php?mid=addtype&alert=2';
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
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?mid=mstype'>
			<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=mstype'>
			<button type="button" class="close">×</button>
		</a>
		<strong>DENIED !</strong> mohon maaf, Data gagal disimpan.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------
?>
<br>
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">Form Tambah Type
	<div style="float:right;">
			<a href='main.php?mid=mstype'><input class="btn btn-info btn-sm" type=button value='Data Type'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Type <i class="fa fa-arrow-right"></i>&nbsp; Tambah Type</i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Type</td>
		<td width="20%">
		<input type='text' id='kd_type'  name="kd_type" placeholder="Cth : TYP001" readonly class="form-control ukuran10">
		</td>
		<td>
		<i class="ket">&nbsp;*Kode unik terisi otomatis</i>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td width="25%">Kode Kategori</td>
		<td colspan="2">
		<select id='kd_kategori' name="kd_kategori" class="form-control ukuran5">
		<option value='0'>~ Pilih Kategori ~</option>
		<?php
		$sqlkategori = mssql_query("SELECT * FROM mskategori WHERE data_status = 'A'");
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
		<td colspan="2"><input type='text' id='type' name="type" placeholder="Cth : Meja" class="form-control ukuran5"></td>
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
	        	~ Form tambah type digunakan untuk menambah master type Arsip. <br>
	        	~ Kode kategori bertanda '<i class="ket">&nbsp;*Kode unik terisi otomatis</i>', artinya kode tersebut tidak perlu diisi karena akan otomatis terbentuk oleh system ketika user mengisi nama type dan menyimpan data.<br>
	        	~ Pilih Kategori untuk menentukan type tersebut termasuk turunan dari kategori tertentu.
	        </p>
	    </div>
	</div>
	</div>
</div>

