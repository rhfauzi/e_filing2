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
}elseif($_GET['alert'] == '3'){
?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">x</button>
		<strong>SUCCESS !</strong> Data Berhasil diapprove.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------
?>
<h3>Pengaturan Type</h3>
<div style="float:right;">
<?php
if($level =='2'){
?>
<a id='tambah' href='main.php?mid=addtype'><input class="btn btn-primary" type=button value='Tambah Type'></a>
<?php
}
?>
</div>

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Type</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr>
		<th width="5%">No</th>
		<th width="15%">Kategori</th>
		<th width="10%">Kode Type</th>
		<th width="15%">Nama Type</th>
		<th width="8%">Status</th>
		<th width="18%">Aksi</th>
	</tr>
</thead>
<tbody>
	<?php

		$Query	=	mssql_query("SELECT a.*,b.nm_kategori,c.data_status as status,c.icon,ROW_NUMBER() over (order by a.kd_type) as row
								FROM mstype a,mskategori b,msdata_status c 
								WHERE a.kd_kategori = b.kd_kategori
								AND a.data_status = c.kode_datastatus
								ORDER by kd_type desc");
		
		while($res	=	mssql_fetch_assoc($Query)){

		$cekarsip = mssql_num_rows(mssql_query("SELECT * FROM arsip WHERE kd_type = '".$res['kd_type']."'"));

	?>
	<tr>
		<td align="center"><?php echo $res['row'];?></td>
		<td><?php echo $res['kd_kategori']." / ".$res['nm_kategori'];?></td>
		<td><?php echo $res['kd_type'];?></td>
		<td><?php echo $res['nm_type'];?></td>	
		<td><?php echo $res['status']."&nbsp;<img src='images/".$res['icon']."' width=15px height=15px>";?></td>
		<td align="right">
		<?php 

		$delete_off 	= "<input class='btn btn-outline btn-danger btn-xs disabled gelap' type=button value=Hapus>";
		$edit_off   	= "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Ubah'>";
		$approve_off 	= "<input class='btn btn-outline btn-primary btn-xs disabled gelap' type=button value='Approve Data'>";


		$edit_on 		= "<a style='text-decoration:none;' href='main.php?mid=edittype&id=".$res['id_type']."' style='text-decoration:none;'>
				<input class='btn btn-outline btn-success btn-xs' type=button value='Ubah'></a>";
		$delete_on 		= "<a style='text-decoration:none;' href=javascript:confirmDelete('execute/exc_master.php?act=deltype&id=".$res['id_type']."')><input class='btn btn-outline btn-danger btn-xs' type=button value='Hapus'></a>";
		$approve_on 	= "<a style='text-decoration:none;' style='text-decoration:none;' href='execute/exc_master.php?act=approve_type&id=".$res['id_type']."'><input class='btn btn-outline btn-primary btn-xs' type=button value='Approve Data'></a>";


		if($level == '1' || $level == '3' || $level == '4' || $level == '5'){
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
				if($cekarsip > 0 )	{
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
        <p style="font-size:12px"> jika data type bertanda seperti ini '<i style='color:#02c42e;'>active</i>' pada kolom aksi artinya data tersebut telah digunakan atau dikaitkan pada Data Arsip.</p>
    </div>
</div>
</div>