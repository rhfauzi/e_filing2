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
<h3>Pengaturan User</h3>
	<div style="float:right;">
	<a id='tambah' href='main.php?mid=adduser'><input class="btn btn-primary" type=button value='Tambah User'></a>
	</div>

<div><i class="ketmenu">Access Role <i class="fa fa-arrow-right"></i>&nbsp; User</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr>
		<th width="5%">No</th>
		<th>ID User / NIP </th>
		<th>Nama Pegawai </th>
		<th>Username</th>
		<th>Group Menu</th>
		<th>Aksi</th>
	</tr>
</thead>
<tbody>
	<?php

	$user 	= tb_user_aplikasi();

		$selectUserMenu	=	mssql_query("SELECT a.nm_pegawai,a.kd_pegawai,a.usernamePegawai,
											a.pass_pegawai,b.iduser,b.idmenuuser,
											b.groupmenu,d.groupdeskripsi
											FROM $user a,usermenu b,groupbsam d
											WHERE a.id_pegawai = b.iduser
											AND b.groupmenu = d.groupmenu
											AND b.groupmenu ! = 1");

		$no=1;
		while($sum		=	mssql_fetch_assoc($selectUserMenu)){
	?>
	<tr>
	<td align="center"><?php echo $no;?></td>
	<td><?php echo $sum['iduser']." / ".$sum['kd_pegawai'];?></td>
	<td><?php echo $sum['nm_pegawai'];?></td>
	<td><?php echo $sum['usernamePegawai'];?></td>
	<td><?php echo "(".$sum['groupmenu'].") ".$sum['groupdeskripsi'];?></td>
	<td align="right">
		<a style='text-decoration:none;' href='main.php?mid=edituser&id=<?php echo $sum['iduser'];?>&groupmenu=<?php echo $sum['groupmenu'];?>'>
			<input class="btn btn-outline btn-success btn-xs" type=button value='Ubah'>
		</a>
	<?php echo "&nbsp;" ?>
		<a href=javascript:confirmDelete('execute/exc_setting.php?act=deluser&id=<?php echo $sum['iduser'];?>&groupmenu=<?php echo $sum['groupmenu'];?>')>
			<input class='btn btn-outline btn-danger btn-xs' type=button value='Hapus'>
		</a>
	</td>		
	</tr>
	<?php
	$no++;	
	}
	?>
</tbody>	
</table>
