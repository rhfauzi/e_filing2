<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>SUCCESS !</strong> Data berhasil dihapus. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>DENIED !</strong> mohon maaf, Data gagal dihapus.
	</div>
<?php
}elseif($_GET['alert'] == '3'){
?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>SUCCESS !</strong> Data Berhasil diapprove.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------
?>
<h3>Pengaturan Box</h3>
<div style="float:right;">
<a id='tambah' href='main.php?mid=addbox'><input class="btn btn-primary" type=button value='Tambah Box'></a>
</div>

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Box</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr>
		<th>No</th>
		<th>Kode Lokasi</th>
		<th>Kode Rak</th>
		<th>Kode Box</th>
		<th>Status</th>
		<th>Aksi</th>
	</tr>
</thead>
<tbody>
	<?php

		$Query	=	mssql_query("SELECT a.*,b.data_status as status,b.icon,ROW_NUMBER() over(order by a.id_box desc) as row 
									FROM msbox a, msdata_status b
									WHERE a.data_status = b.kode_datastatus order by a.id_box desc");
		
		while($res	=	mssql_fetch_assoc($Query)){

		$cekarsip = mssql_num_rows(mssql_query("SELECT * FROM arsip WHERE kd_box = '".$res['kd_box']."'"));
		
	?>
	<tr>
		<td align="center"><?php echo $res['row'];?></td>
		<td><?php echo $res['kd_lokasi'];?></td>
		<td><?php echo $res['kd_rak'];?></td>
		<td><?php echo $res['kd_box'];?></td>
		<td><?php echo $res['status']."&nbsp;<img src='images/".$res['icon']."' width=15px height=15px>";?></td>
		<td align="right">
			
		<?php

		$delete_off 	= "<input class='btn btn-outline btn-danger btn-xs disabled gelap' type=button value=Hapus>";
		$edit_off   	= "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Ubah'>";
		$approve_off 	= "<input class='btn btn-outline btn-primary btn-xs disabled gelap' type=button value='Approve Data'>";


		$edit_on 		= "<a style='text-decoration:none;' href='main.php?mid=editbox&id=".$res['id_box']."'>
				<input class='btn btn-outline btn-success btn-xs' type=button value='Ubah'></a>";
		$delete_on 		= "<a style='text-decoration:none;' href=javascript:confirmDelete('execute/exc_master.php?act=delbox&id=".$res['id_box']."')><input class='btn btn-outline btn-danger btn-xs' type=button value='Hapus'></a>";
		$approve_on 	= "<a style='text-decoration:none;' href='execute/exc_master.php?act=approve_box&id=".$res['id_box']."'><input class='btn btn-outline btn-primary btn-xs' type=button value='Approve Data'></a>";

		if($level == '1' || $level == '4' || $level == '5'){
			if($res['data_status'] != 'A'){
				echo $edit_off."&nbsp;";
				echo $delete_on."&nbsp;";
				echo $approve_on."&nbsp;";
			}else{
				echo $edit_off."&nbsp;";
				echo $delete_off."&nbsp;";
				echo $approve_off."&nbsp;";
			}

			if($cekarsip > 0 )	{
					echo "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
			}
			
		}else{
			if($res['data_status'] != 'A'){
				if($cekarsip > 0 )	{
					echo "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
					echo $edit_off."&nbsp;";
					echo $delete_off."&nbsp;";
					echo $approve_off."&nbsp;";
				}else{
					echo $edit_on."&nbsp;";
					echo $delete_on."&nbsp;";
					echo $approve_off."&nbsp;";
				}
				
			}else{
				if($cekarsip > 0 ){
					echo "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
					echo $edit_off."&nbsp;";
					echo $delete_off."&nbsp;";
					echo $approve_off."&nbsp;";
				}else{
					echo $edit_off."&nbsp;";
					echo $delete_off."&nbsp;";
					echo $approve_off."&nbsp;";
				}
			}
		}
		?>
		</td>	
	</tr>
	<?php
	}
	?>
	</tbody>
</table>
<div class="col-lg-13">
<div class="panel panel-info">
    <div class="panel-heading">
        Informasi
    </div>
    <div class="panel-body">
        <p style="font-size:12px"> jika data box bertanda seperti ini '<i style='color:#02c42e;'>active</i>' pada kolom aksi artinya data tersebut telah digunakan atau dikaitkan pada Data Arsip.</p>
    </div>
</div>
</div>
