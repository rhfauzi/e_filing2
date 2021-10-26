<?php
if($param1 == 'alert')
{
	//------------------------------------------- ALERT MESSAGE ------------------------------------	
	if($isiParam1 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>SUCCESS !</strong> Data berhasil <?php echo $isiParam2; ?>. 
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>DENIED !</strong> mohon maaf, Data gagal <?php echo $isiParam2; ?>. mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------
?>
<h3>Pengaturan Kategori</h3>
<div style="float:right;">
<?php
//if(in_array($level,$arr_group_master)){
$url    = "mid=addkategori";
$urlEnc = $edc->encrypt($url,true);
echo "<a id='tambah' href='main.php?".$urlEnc."'><input class='btn btn-primary' type=button value='Tambah Kategori'></a>";
//}
?>
</div>

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Kategori</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr class="softblue">
		<th width="3%">No</th>
		<th width="8%">Kode</th>
		<th width="20%">Nama Kategori</th>
		<th width="10%">Status</th>
		<th width="20%">Log</th>
		<th width="22%">Aksi</th>
	</tr>
</thead>
<tbody>
	<?php

		$Query	=	mssql_query("SELECT a.*,b.data_status as status,b.icon,ROW_NUMBER() over(order by a.id_kategori desc) as row 
								FROM mskategori a,msdata_status b 
								WHERE a.data_status = b.kode_datastatus order by a.id_kategori desc");

		while($res	=	mssql_fetch_assoc($Query)){

		$cekarsip = mssql_num_rows(mssql_query("SELECT * FROM arsip WHERE kd_kategori = '".$res['kd_kategori']."'"));
		
	?>
	<tr>
		<td align="center"><?php echo $res['row'];?></td>
		<td><?php echo $res['kd_kategori'];?></td>
		<td><?php echo $res['nm_kategori'];?></td>
		<td><?php echo $res['status']."&nbsp;<img src='images/".$res['icon']."' width=15px height=15px>";?></td>
		<td><?php echo $res['input_date']." | ".infouser($res['input_user']);?></td>
		<td align="right">
			
		<?php

		$delete_off 	= "<input class='btn btn-outline btn-danger btn-xs disabled gelap' type=button value=Hapus>";
		$edit_off   	= "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Ubah'>";
		$approve_off 	= "<input class='btn btn-outline btn-primary btn-xs disabled gelap' type=button value='Approve Data'>";

		$urlEdit    = "mid=editkategori&id=".$res['id_kategori'];
		$urlEditEnc = $edc->encrypt($urlEdit,true);

		$edit_on 		= "<a style='text-decoration:none;' href='main.php?".$urlEditEnc."'>
				<input class='btn btn-outline btn-success btn-xs' type=button value='Ubah'></a>";
		$delete_on 		= "<a style='text-decoration:none;' href=javascript:confirmDelete('execute/exc_master.php?act=delkategori&id=".$res['id_kategori']."')><input class='btn btn-outline btn-danger btn-xs' type=button value='Hapus'></a>";
		$approve_on 	= "<a style='text-decoration:none;' style='text-decoration:none;' href=javascript:confirmApprove('execute/exc_master.php?act=approve_kategori&id=".$res['id_kategori']."')><input class='btn btn-outline btn-primary btn-xs' type=button value='Approve Data'></a>";

		// jika yang login approver supervisor/manager/general
		if($level == '3' || $level == '4' || $level == '5'){
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
		//jika yang login  admin
		}else if($level == '8'){
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
				}
					echo $edit_off."&nbsp;";
					echo $delete_off."&nbsp;";
					echo $approve_off."&nbsp;";
			}
		// jika yang login super admin
		}else if($level == '1'){
			if($res['data_status'] != 'A'){
				if($cekarsip > 0 )	{
					echo "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
					echo $edit_off."&nbsp;";
					echo $delete_off."&nbsp;";
					echo $approve_off."&nbsp;";
				}else{
					echo $edit_on."&nbsp;";
					echo $delete_on."&nbsp;";
					echo $approve_on."&nbsp;";
				}
				
			}else{
				if($cekarsip > 0 )	{
					echo "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
				}

				echo $edit_off."&nbsp;";
				echo $delete_off."&nbsp;";
				echo $approve_off."&nbsp;";
			}
		}else{
			echo $edit_off."&nbsp;";
			echo $delete_off."&nbsp;";
			echo $approve_off."&nbsp;";
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
        <p style="font-size:12px"> jika data kategori bertanda seperti ini '<i style='color:#02c42e;'>active</i>' pada kolom aksi artinya data tersebut telah digunakan atau dikaitkan pada Data Arsip.</p>
    </div>
</div>
</div>
