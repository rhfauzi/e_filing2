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
</script>

	<h3>Pengaturan Group</h3>
	<div style="float:right;">
	<a id='tambah' href='main.php?mid=addgroup'><input class="btn btn-primary" type=button value='Tambah Group'></a>
	</div>

<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp; Group</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr>
		<th width="7%">No</th>
		<th>Nama Group </th>
		<th>No Group </th>
		<th>Aksi</th>
	</tr>
</thead>
<tbody>
	<?php
	$no = 1;
		$selectDaftarMenu	=	mssql_query("SELECT * FROM groupbsam WHERE idgroupbsam not IN(1) ORDER BY idgroupbsam DESC");
		while($sdm			=	mssql_fetch_assoc($selectDaftarMenu)){
	?>
	<tr>
		<td align="center"><?php echo $no;?></td>
		<td><?php echo $sdm['groupdeskripsi'];?></td>
		<td><?php echo $sdm['groupmenu'];?></td>
		<td align="right">
		<a style='text-decoration:none;' href="main.php?mid=editgroup&id=<?php echo $sdm['idgroupbsam'];?>">
		<input class="btn btn-outline btn-success btn-xs" type=button value='Ubah'>
		</a>
		<?php echo "&nbsp;" ?>
		<a href=javascript:confirmDelete('execute/exc_setting.php?act=delgroup&id=<?php echo $sdm['idgroupbsam'];?>')>
		<input class="btn btn-outline btn-danger btn-xs" type=button value='Hapus'>
		</a>
		</td>		
	</tr>
	<?php
	$no++;
	}
	?>
	</tbody>
</table>


