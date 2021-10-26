
<!-- <script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script> -->

<!-- <script type="text/javascript" src="js/jquery-1.4.js"></script>  -->


<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">x</button>
		<strong>DENIED !</strong> mohon maaf, Data gagal disimpan.
	</div>
<?php
}
?>

<br>
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">Form Ubah Group
	<div style="float:right;">
			<a href='main.php?mid=groupmenu'><input class="btn btn-info btn-sm" type=button value='Data Akses Group'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp;Akses Group <i class="fa fa-arrow-right"></i>&nbsp;Ubah Group </i></div><br>

<form action='execute/exc_setting.php' method='POST'>
<table border='0px' width='100%' style='font-size:14px;'>
	<tr>
		<td>Group Menu</td>
		<td>:</td>
		<td width="30%">
		<?php
			$selectDropDown	=	mssql_query("SELECT groupmenu,groupdeskripsi FROM groupbsam WHERE groupmenu = '".$_GET['groupmenu']."'");
			$mns			=	mssql_fetch_assoc($selectDropDown);
		?>
			
			<input type='text' class="form-control ukuran10" readonly name='groupmenutext' value='<?php echo $mns['groupdeskripsi'];?>'>
			<input type='hidden' class="form-control ukuran5" name='groupmenu' value='<?php echo $mns['groupmenu'];?>'>
		</td>
		<td>
		<i class="ket">&nbsp;*Group Menu</i>
		</td>
	</tr>
	<tr><td height="10px"></td></tr>
	<tr>
		<td valign='top'>Pilih Menu</td>
		<td valign='top'>:</td>
		<td valign='top' colspan="2">
			
			<?php 
			$cekBox		=	mssql_query("SELECT idmenu,namamenu FROM menu WHERE idutama = '1' AND idmenu <> '1' ORDER BY menuorder ASC");
			$no = 1;
			while($cb	=	mssql_fetch_assoc($cekBox)){
					echo "<b><u>".$cb['namamenu']."</u></b><br>";
					$cekBoxSub	=	mssql_query("SELECT idmenu,namamenu FROM menu WHERE menupendahulu = '".$cb['idmenu']."'");
					while($sm			=	mssql_fetch_assoc($cekBoxSub)){
					echo "<input type='hidden' name='jml[]'>";
					$queryS				=	"SELECT * FROM groupmenu WHERE groupmenu = '".$_GET['groupmenu']."' AND idmenu = '".$sm['idmenu']."'";
					$selectUpdateCek	=	mssql_query($queryS);
					//echo $queryS.'<br>';
					$cekSuc				=	mssql_num_rows($selectUpdateCek);
					if($cekSuc			!= 0){
						$ceked			=	'checked';
					}else{
						$ceked			=	'';
					}
					//echo $ceked;
					echo "<input $ceked type='checkbox' name='idmenu_$no' value='".$sm['idmenu']."'> ".$sm['namamenu']."<br>";
					$no++;
					}
					
			}?>
		<i></i></td>
	</tr>
	<tr><td height="30px"></td></tr>
	<tr>
		<td></td>
		<td></td>
		<td colspan="2" align="right"><input type='submit' name='updateGroupMenu' class="btn btn-outline btn-warning" value='UPDATE'></td>
	</tr>
</table>
<br>
</form>
</div>
</div>
</div>
</div>
</div>

