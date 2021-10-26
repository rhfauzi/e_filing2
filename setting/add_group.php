<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 

<script>
$(document).ready(function() {
	$("#simpan").click(function(){
				var	groupmenu		=	$("#groupmenu").val();
				var	groupdeskripsi	=	$("#groupdeskripsi").val();
				
					$.ajax({
						type: "POST",
						data: "act=addgroup&groupmenu="+groupmenu+"&groupdeskripsi="+groupdeskripsi,
						url: "execute/exc_setting.php",
						success: function(data){
							 $("#groupmenu").val("");
							 $("#groupdeskripsi").val("");
							 
							 if(data ==''){
							 	window.location = 'main.php?mid=addgroup&alert=1';
							 }else{
							 	window.location = 'main.php?mid=addgroup&alert=2';
							 }	
							 // alert(data);
						}
					});
	});
});
</script>
<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------
include "function/seqno.php";	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?mid=groupbrins'>
			<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=groupbrins'>
		<button type="button" class="close">×</button>
		</a>
		<strong>DENIED !</strong> mohon maaf, Data gagal disimpan.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------

$groupMenuUbah	= noUrutGroupBsam();

?>
<br>
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">Form Tambah Group
	<div style="float:right;">
			<a href='main.php?mid=groupbrins'><input class="btn btn-info btn-sm" type=button value='Data Group'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">


<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp;Group <i class="fa fa-arrow-right"></i>&nbsp;Tambah Group </i></div><br>

<table width="100%" border='0px'>
	<tr>
		<td width="20%">Kode Group</td>
		<td width="5%"><input type='text' id='groupmenu' name='groupmenu' class="form-control ukuran10" readonly value ='<?php echo $groupMenuUbah;?>'> 
		</td>
		<td><i class="ket">&nbsp;*Nomor Unik tidak boleh sama</i></td>
	</tr>
	<tr><td height=10px colspan="3"></td></tr>
	<tr>
		<td>Deskripsi Group</td>
		<td colspan="2"><input type='text' id='groupdeskripsi' class="form-control ukuran5" name='groupdeskripsi'></td>
	</tr>
	<tr><td height=30px colspan="3"></td></tr>
	<tr>
	<td></td>
	<td colspan="2" align="right"><button id='simpan' class="btn btn-outline btn-primary">Simpan</button></td>
	</tr>
</table>
<br>
</div>
</div>
</div>
</div>
</div>





