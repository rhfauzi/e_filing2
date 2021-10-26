<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script>

<script>
$(document).ready(function() {

$("#simpan").click(function(){
				var	groupmenu		=	$("#groupmenu").val();
				var	iduser			=	$("#iduser").val();
				var	id				=	$("#id").val();
			
					$.ajax({
						type: "POST",
						data: "act=edituser&groupmenu="+groupmenu+"&iduser="+iduser,
						url: "execute/exc_setting.php",
						success: function(data){
							 if(data ==''){
							 	window.location = 'main.php?mid=edituser&alert=1&id='+id+'&groupmenu='+groupmenu;
							 }else{
							 	window.location = 'main.php?mid=edituser&alert=2';
							 }	
							 //alert(data);
						}
					});
});
});

</script>
<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?mid=usermenu'>
		<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil dirubah. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=usermenu'>
			<button type="button" class="close">×</button>
		</a>
		<strong>DENIED !</strong> mohon maaf, Data gagal dirubah.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------

$userapp 	= tb_user_aplikasi();

$selectUbahAkses = mssql_query("SELECT * FROM $userapp WHERE id_pegawai ='".$_GET['id']."'");
$su	= mssql_fetch_assoc($selectUbahAkses);
?>
<br>
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">Form Edit User
	<div style="float:right;">
			<a href='main.php?mid=usermenu'><input class="btn btn-info btn-sm" type=button value='Data User'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp;User <i class="fa fa-arrow-right"></i>&nbsp;Ubah </i></div><br>
<table  border='0px' width='100%'>
	<tr>
		<td width="20%">Nama User</td>
		<td colspan="2">
		<input type="hidden" id=id name=id value="<?php echo $su[id_pegawai]; ?>">
		<input type='text' id='iduser' class="form-control ukuran5" readonly value='<?php echo $su[id_pegawai].'-'.$su[nm_pegawai].'-'.$su[kd_pegawai];?>'></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Group Menu</td>
		<td width="25%"><select id='groupmenu' class="form-control ukuran10"> 
				<?php
			
					$selectDropDown	=	mssql_query("SELECT groupmenu,groupdeskripsi FROM groupbsam WHERE groupmenu > '1' ORDER BY idgroupbsam ASC");
					while($mns	=	mssql_fetch_assoc($selectDropDown)){

					if($mns['groupmenu'] == $_GET['groupmenu']){
						$selected	=	'selected';
					}else{
						$selected	=	'';
					}
						echo '<option '.$selected.' value='.$mns['groupmenu'].'>'.$mns['groupdeskripsi'].'</option>';
					}
				?>
			</select>
		</td>
		<td>
		<i class="ket">&nbsp;*Group Menu</i>
		</td>
	</tr>
	<tr><td height="30px" colspan="3"></td></tr>
	<tr>
		<td></td>
		<td colspan="2" align="right"><button id='simpan' class="btn btn-outline btn-primary">SIMPAN</button></td>
	</tr>
</table>
<br>
</div></div></div></div></div>