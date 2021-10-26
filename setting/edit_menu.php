<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script>

<?php
if(!empty($_GET['idmenu'])){
	$updateMenu	=	mssql_query("SELECT * FROM menu WHERE idmenu = '$_GET[idmenu]'");
	$um			=	mssql_fetch_assoc($updateMenu);
}
?> 
<script>//Proses Input
$(document).ready(function() {

//CLICK SUBMIT
function awal(){
var	baris	=	$("#idutama").val();
				
				if(baris == 1 || baris == 3){
					$("#menupendahulu").attr('disabled', true);
					if(baris == 1){
						$("#menuprogram").val("#");
					}else{
						$("#menuprogram").val();
					}
					var	menupendahulu		=	0;
				}else{
					$("#menupendahulu").attr('disabled', false);
					
					var	menupendahulu	=	$("#menupendahulu").val();
				}
}
awal();
$("#idutama").change(function(){
				var	baris	=	$("#idutama").val();
				
				if(baris == 1 || baris == 3){
					$("#menupendahulu").attr('disabled', true);
					if(baris == 1){
						$("#menuprogram").val("#");
					}else{
						$("#menuprogram").val();
					}
					var	menupendahulu		=	0;
				}else{
					$("#menupendahulu").attr('disabled', false);
					$("#menuprogram").val("");
					var	menupendahulu	=	$("#menupendahulu").val();
				}
					
});

$("#updatemenu").click(function(){
				var	idmenu		=	$("#idmenu").val();
				var	idutama		=	$("#idutama").val();
				var	namamenu	=	$("#namamenu").val();
				var	menuprogram	=	$("#menuprogram").val();
				var	menuorder	=	$("#menuorder").val();
				var	filemenu	=	$("#filemenu").val();
				var	status		=	$("#status:checked").val();
				
				if(idutama == 1 || idutama == 3){
					var	menupendahulu		=	0;
				}else{
					var	menupendahulu	=	$("#menupendahulu").val();
				}
					$.ajax({
						type: "POST",
						data: "act=editmenu&idmenu="+idmenu+"&idutama="+idutama+"&namamenu="+namamenu+"&menuprogram="+menuprogram+"&menupendahulu="+menupendahulu+"&menuorder="+menuorder+"&filemenu="+filemenu+"&status="+status,
						url: "execute/exc_setting.php",
						success: function(data){
							 if(data ==''){
							 	window.location = "main.php?mid=editmenu&alert=1&idmenu="+idmenu;
							 }else{
							 	window.location = 'main.php?mid=editmenu&alert=2';
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
		<a href='main.php?mid=menu'>
		<button type="button" class="close">x</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil dirubah. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=menu'>
			<button type="button" class="close">x</button>
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
<div class="panel-heading">Form Edit Menu
	<div style="float:right;">
			<a href='main.php?mid=menu'><input class="btn btn-info btn-sm" type=button value='Data Menu'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp;Menu <i class="fa fa-arrow-right"></i>&nbsp;Ubah </i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="20%"><label>ID Menu</label></td>
		<td width="45%">
		<input type='text' readonly id='idmenu' size='1' class="form-control ukuran1" value="<?php echo $um['idmenu'];?>">
		</td>
		<td><i class=ket>&nbsp; *Nomor Unik tidak boleh sama</i></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Menu/Sub-Menu</td>
		<td><input type='text' id='idutama' size='1' class="form-control ukuran4" value="<?php echo $um['idutama'];?>"></td>
		<td><i class="ket">&nbsp; *1 = Menu, 2 = Sub Menu,3 = Link Menu</i></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Nama Menu</td>
		<td colspan="2" colspan="2"><input type='text' id='namamenu' class="form-control ukuran4" value="<?php echo $um['namamenu'];?>"> <i></i></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Alias</td>
		<td colspan="2" colspan="3"><input type='text' id='menuprogram' class="form-control ukuran4" value="<?php echo $um['menuprogram'];?>"></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>File Menu</td>
		<td><input type='text' id='filemenu' class="form-control ukuran10" value="<?php echo $um['filemenu'];?>"></td>
		<td><i class=ket>&nbsp;  *nama file cth menu.php</i></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Menu Pendahulu</td>
		<td colspan="2"><select id='menupendahulu' class="form-control ukuran2"> 
				<?php
				
					$selectDropDown	=	mssql_query("SELECT idmenu,namamenu FROM menu WHERE idutama='1' AND idmenu > '1' ORDER BY menuorder ASC");
					while($mns	=	mssql_fetch_assoc($selectDropDown)){
					if($mns['idmenu'] == $um['menupendahulu']){
						$selecte	=	'selected';
					}else{
						$selecte	=	'';
					}
						echo '<option '.$selecte.' value='.$mns['idmenu'].'>'.$mns['namamenu'].'</option>';
					}
				?>
			</select>
		<i></i></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Menu Order</td>
		<td><input type='text' id='menuorder' class="form-control ukuran1" value="<?php echo $um['menuorder'];?>"></td>
		<td> <i class=ket>&nbsp; *No. Urut</i></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Status</td>
		<td colspan="2">
		<?php 
		if($um['aktif'] == 'Y'){$ceky = "checked='checked'"; $cekn = "";}
		elseif($um['aktif'] == 'N'){$ceky = ""; $cekn = "checked='checked'";}
		?>
		<input type='radio' name='status' id='status' value='Y' <?php echo $ceky; ?>> Aktif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='status' id='status' value='N' <?php echo $cekn; ?>> Non Aktif
		</td>
	</tr>
	<tr><td height="30px" colspan="3" ></td></tr>
	<tr>
		<td></td>
		<td colspan="2" align="right"><button id='updatemenu' class="btn btn-outline btn-warning">Update</button></td>
	</tr>
</table>
<br>
</div>
</div>
</div>
</div>
</div>
