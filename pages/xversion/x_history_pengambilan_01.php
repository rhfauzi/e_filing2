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
<h3>Data Histori Pengambilan Arsip</h3>
<div style="float:right;">

</div>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pengambilan</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr>
		<th width="3%">No</th>
		<th width="10%">Kode Arsip</th>
		<th width="15%">Nama Pengambil</th>
		<th width="10%">Keperluan</th>
		<th width="10%">Tgl Ambil</th>
		<th width="10%">Tgl Kembali</th>
		<th width="5%">Status</th>
		<?php if($level == '1' || $level == '2'){?>
			<th width="10%">Aksi</th>
		<?php } ?>
	</tr>
</thead>
<tbody>
	<?php

	$no =1;

		$QueMain	=	mssql_query("SELECT * FROM pengambilan ORDER by id_pengambilan DESC");
		
		while($res	=	mssql_fetch_assoc($QueMain)){

		//jika yang login super admin dan admin/PIC
		if($level == '1' || $level == '2'){
			if($res['status'] == '4'){//status DONE lihat table msstatus
				$masuk_kembali  = "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Masukan Kembali'>";
			}else{
				$masuk_kembali  = "<a style='text-decoration:none;' href='main.php?mid=pengambilan_arsip&kd_arsip=".$res['kd_arsip']."&id=".$res['id_pengambilan']."'>
				<input class='btn btn-outline btn-success btn-xs' type=button value='Masukan kembali'></a>";
			}
		}else{
			$masuk_kembali  = "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Masukan Kembali'>";
		}

	?>
	<tr>
		<td align="center"><?php echo $no;?></td>
		<td>
			<a href='main.php?mid=listarsip_detail&kd_arsip=<?php echo $res[kd_arsip];?>'><?php echo $res['kd_arsip'];?></a>
		</td>
		<td><?php echo $res['nama_pengambil'];?></td>
		<td><?php echo $res['keperluan'];?></td>
		<td><?php echo ShortDate($res['tgl_ambil']);?></td>
		<td><?php echo ShortDate($res['tgl_kembali']);?></td>
		<?php 
		$stat = mssql_fetch_assoc(mssql_query("SELECT * FROM msstatus where id_status = '".$res['status']."'"));
		?>
		<td <?php echo $stat['style'];?>><b><i><?php echo $stat['status'];?></i></b></td>
		<?php if($level == '1' || $level == '2'){?>
			<td align="right">
			<?php echo $masuk_kembali."&nbsp;" ?>
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

