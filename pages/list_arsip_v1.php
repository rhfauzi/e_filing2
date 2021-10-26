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
<h3>Daftar Arsip</h3>
<div style="float:right;">
<?php
if(in_array($level,$arr_group_editor)){
	echo "<a id='tambah' href='main.php?mid=addarsip'><input class='btn btn-primary' type=button value='Tambah Arsip'></a>";
	echo "&nbsp";
}
?>
</div>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Daftar Arsip</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr>
		<th width="3%">No</th>
		<th width="10%">Kode Arsip</th>
		<th width="15%">Nama Arsip</th>
		<th width="10%">Kategori</th>
		<th width="5%"><font style='color:green;'>L</font></th>
		<th width="5%"><font style='color:blue;'>R</font></th>
		<th width="5%"><font style='color:orange;'>B</font></th>
		<th width="5%">Status</th>
		<?php if(in_array($level,$arr_group_editor)){?>
			<th width="10%">Aksi</th>
		<?php } ?>
	</tr>
</thead>
<tbody>
	<?php

	$no =1;

		$QueMain	=	mssql_query("SELECT * FROM arsip ORDER by id_arsip DESC");
		
		while($res	=	mssql_fetch_assoc($QueMain)){

		//jika yang login super admin dan admin/PIC
		if(in_array($level,$arr_group_editor)){
			$ubah  = "<a style='text-decoration:none;' href='main.php?mid=addarsip_laststep&id_arsip=".$res['id_arsip']."'>
			<input class='btn btn-outline btn-success btn-xs' type=button value='Ubah'></a>";
			$hapus = "<a style='text-decoration:none;' href=javascript:confirmDelete('execute/exc_program.php?act=delarsip&kd_arsip=".$res['kd_arsip']."')>
			<input class='btn btn-outline btn-danger btn-xs' type=button value='Hapus'></a>";
		}else{
			$ubah  = "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Ubah'>";
			$hapus = "<input class='btn btn-outline btn-danger btn-xs disabled gelap' type=button value='Hapus'>";
		}

		$QueKat 	= mssql_fetch_assoc(mssql_query("SELECT * FROM mskategori WHERE kd_kategori = '".$res['kd_kategori']."'"));

	?>
	<tr>
		<td align="center"><?php echo $no;?></td>
		<td>
			<a href='main.php?mid=listarsip_detail&kd_arsip=<?php echo $res[kd_arsip];?>'><?php echo $res['kd_arsip'];?></a>
		</td>
		<td><?php echo $res['nama_arsip'];?></td>
		<td><?php echo $QueKat['nm_kategori'];?></td>
		<td><?php echo $res['kd_lokasi'];?></td>
		<td><?php echo $res['kd_rak'];?></td>
		<td><?php echo $res['kd_box'];?></td>
		<?php 
		$stat = mssql_fetch_assoc(mssql_query("SELECT * FROM msstatus where id_status = '".$res['status']."'"));
		?>
		<td <?php echo $stat['style'];?>><b><i><?php echo $stat['status'];?></i></b></td>
		
		<?php if(in_array($level,$arr_group_editor)){?>
			<td align="right">
			<?php echo $ubah."&nbsp;".$hapus ?>
			</td>
		<?php } ?>
	</tr>
	<?php
	$no++;
	}
	?>
	</tbody>
</table>
<div class="col-lg-13">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body" align="justify">
	        <p style="font-size:12px">
	        	~ <b>Daftar Arsip</b> digunakan untuk melihat data-data arsip yang ada.<br>
	        	~ 	<font style='color:green;'><b>L</b></font> = Lokasi,
					<font style='color:blue;'><b>R</b></font> = Rak,
					<font style='color:orange;'><b>B</b></font> = Box<br>
				~ klik button <input class="btn btn-outline btn-success btn-xs" type=button value='Ubah'> jika ingin merubah data arsip, yang akan menuju form ubah arsip.<br>
				~ Klik button <input class="btn btn-outline btn-danger btn-xs" type=button value='Hapus'> jika ingin menghapus data arsip.
				~ Button tersebut aktif sesuai akses level masing - masing user.
	        </p>
	    </div>
	</div>
</div>
