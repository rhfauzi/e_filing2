<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

$("#menupendahulu").attr('disabled', true);
$("#menuprogram").val("#");
$("#idutama").click(function(){
				var	baris	=	$("#idutama").val();
				
				if(baris == 1 || baris == 3){
					$("#menupendahulu").attr('disabled', true);
					if(baris == 1){
						$("#menuprogram").val("#");
					}else{
						$("#menuprogram").val("");
					}
					var	menupendahulu		=	0;
				}else{
					$("#menupendahulu").attr('disabled', false);
					$("#menuprogram").val("");
					var	menupendahulu	=	$("#menupendahulu").val();
				}
					
});

	$("#simpan").click(function(){
					var	idmenu		=	$("#idmenu").val();
					var	idutama		=	$("#idutama").val();
					var	namamenu	=	$("#namamenu").val();
					var	menuprogram	=	$("#menuprogram").val();
					var	menuorder	=	$("#menuorder").val();
					var	filemenu	=	$("#filemenu").val();
					var	status		=	$("#status:checked").val();

					if(idutama == 1 || idutama == 3){
						var	menupendahulu	=	0;
					}else{
						var	menupendahulu	=	$("#menupendahulu").val();
					}
						$.ajax({
							type: "POST",
							data: "act=addmenu&idmenu="+idmenu+"&idutama="+idutama+"&namamenu="+namamenu+"&menuprogram="+menuprogram+"&menupendahulu="+menupendahulu+"&menuorder="+menuorder+"&filemenu="+filemenu+"&status="+status,
							url: "execute/exc_setting.php",
							success: function(data){
								 $("#idmenu").val("");
								 $("#idutama").val("");
								 $("#namamenu").val("");
								 $("#menuprogram").val("");
								 $("#menuorder").val("");
								 $("#filemenu").val("");
								 $("#status").val("");
								 if(data ==''){
								 	window.location = 'main.php?mid=addmenu&alert=1';
								 }else{
								 	window.location = 'main.php?mid=addmenu&alert=2';
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
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=menu'>
		 <button type="button" class="close">x</button>
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
<div class="panel-heading">Form Tambah Menu
	<div style="float:right;">
			<a href='main.php?mid=menu'><input class="btn btn-info btn-sm" type=button value='Data Menu'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp; Menu <i class="fa fa-arrow-right"></i>&nbsp; Tambah Menu</i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="20%"><label>ID Menu</label></td>
		<td width="45%">
		<input class="form-control ukuran1" type='text' readonly id='idmenu' size='1' value="<?php echo noUrutMenu();?>">
		</td>
		<td><i class="ket">&nbsp; *Nomor Unik tidak boleh sama</i></td>
	</tr>
	<tr><td height="10px"></td></tr>
	<tr>
		<td>Menu/Sub-Menu</td>
		<td colspan="2"><select id='idutama' class="form-control ukuran2"> 
				<option value='1'>Menu Utama</option>
				<option value='2'>Sub Menu</option>
				<option value='3'>Link Menu</option>
		
			</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Nama Menu</td>
		<td colspan="2"><input type='text' id='namamenu' class="form-control ukuran4" size='3'></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Alias</td>
		<td colspan="2"><input type='text' id='menuprogram' class="form-control ukuran4"></td>
	</tr>
	<tr><td height="10px"></td></tr>
	<tr>
		<td>File Menu</td>
		<td><input type='text' id='filemenu' class="form-control  ukuran10">
		</td>
		<td><i class="ket">&nbsp; *nama file cth menu.php</i></td>
	</tr>
	<tr><td height="10px"></td></tr>
	<tr>
		<td>Menu Pendahulu</td>
		<td colspan="2"><select id='menupendahulu' class="form-control ukuran2"> 
				<?php
				
					$selectDropDown	=	mssql_query("SELECT idmenu,namamenu FROM menu WHERE idutama='1' AND idmenu > '1' ORDER BY menuorder ASC");
					while($mns	=	mssql_fetch_assoc($selectDropDown)){
						echo '<option value='.$mns['idmenu'].'>'.$mns['namamenu'].'</option>';
					}
				?>
			</select>
		<i></i></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Menu Order</td>
		<td>
		<input class="form-control ukuran1" type='text' id='menuorder' maxlength='1' onkeyup="OnlyNumb(this)">
		</td>
		<td><i class="ket">&nbsp; *No. Urut</i></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Status</td>
		<td colspan="2">
		<input type='radio' name='status' id='status' value='Y'> Aktif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='status' id='status' value='N'> Non Aktif
		</td>
	</tr>
	<tr><td colspan="2" height="30px"></td></tr>
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

