<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert">x</button>
		<strong>SUCCESS !</strong> Data berhasil dihapus. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">x</button>
		<strong>DENIED !</strong> mohon maaf, Data gagal dihapus.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------
?>
<h3>Pengaturan Menu</h3>
<div style="float:right;">
<a id='tambah' href='main.php?mid=addmenu'><input class="btn btn-primary" type=button value='Tambah Menu'></a>
</div>

<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp; Menu</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr>
		<th>No</th>
		<th>Type</th>
		<th>Nama Menu</th>
		<th>Alias</th>
		<th>File Menu</th>
		<th>Master</th>
		<th>Aktif</th>
		<th>Icon</th>
		<th>Aksi</th>
	</tr>
</thead>
<tbody>
	<?php
	$no =1;
		$sqlmenu	=	mssql_query("SELECT * FROM menu WHERE idmenu > 5 ORDER BY idutama ASC");
		
		while($resmenu	=	mssql_fetch_assoc($sqlmenu)){

		$quemaster = mssql_fetch_assoc(mssql_query("SELECT namamenu from menu WHERE idmenu ='".$resmenu['menupendahulu']."'"));	

		if($resmenu['idutama'] == '1'){
			$nama_type = 'Menu';
		}elseif($resmenu['idutama'] == '2'){
			$nama_type = 'Sub Menu';
		}elseif($resmenu['idutama'] == '3'){
			$nama_type = 'Link Menu';
		}else{
			$nama_type = '';
		}

	?>
	<tr>
		<td align="center"><?php echo $no;?></td>
		<td><?php echo $nama_type;?></td>
		<td><?php echo $resmenu['namamenu'];?></td>
		<td><?php echo $resmenu['menuprogram'];?></td>
		<td><i class="icon-folder-open"><?php echo $resmenu['filemenu'];?></i></td>
		<td><?php echo $quemaster['namamenu'];?></td>
		<td><?php echo $resmenu['aktif'];?></td>
		<td style="text-align: center;">
		<?php
		if($resmenu['icon'] =='' || $resmenu['icon'] == NULL){
			$gambar = "no-image.png";
		}else{
			$gambar = $resmenu['icon'];
		}

		echo "<img src='images/".$gambar."' width='28px' height='28px'>";
		?>
		</td>
		<td align="right">
		<a style='text-decoration:none;' href="main.php?mid=editmenu&idmenu=<?php echo $resmenu['idmenu'];?>">
		<input class="btn btn-outline btn-success btn-xs" type=button value='Ubah'>
		</a>
		<?php echo "&nbsp;" ?>
		<a href=javascript:confirmDelete('execute/exc_setting.php?act=delmenu&id_delmenu=<?php echo $resmenu['idmenu'];?>')>
		<input class="btn btn-outline btn-danger btn-xs" type=button value='Hapus'>
		</a></td>		
	</tr>
	<?php
	$no++;
	}
	?>
	</tbody>
</table>

