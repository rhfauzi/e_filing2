<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($param1 == 'alert')
{
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
<h3 align="center" style='font-family:monospace;color:#777;'>Data Lokasi Arsip</h3>
<div style="float:right;">
<?php
if($level == '8'){
	$url    = "mid=addlokasi";
	$urlEnc = $edc->encrypt($url,true);
	echo "<a id='tambah' href='main.php?".$urlEnc."'><input class='btn btn-primary' type=button value='Tambah Lokasi'></a>";
}
?>

</div>

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Lokasi</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr class="softblue">
		<th width="5%">No</th>
		<th width="8%">Kode</th>
		<th width="12%">Nama Lokasi</th>
		<th width="15%">Alamat</th>
		<th width="10%">Status</th>
		<th width="20%">Log</th>
		<th width="22%">Aksi</th>
	</tr>
</thead>
<tbody>
	<?php

		$Query	=	mssql_query("SELECT a.*,b.data_status as status,b.icon,ROW_NUMBER() over (order by a.id_lokasi) as row 
									FROM mslokasi a,msdata_status b 
									WHERE a.data_status = b.kode_datastatus 
									ORDER BY a.id_lokasi desc");

		while($res	=	mssql_fetch_assoc($Query)){

		$cekarsip = mssql_num_rows(mssql_query("".$func_que_arsip." WHERE kd_lokasi = '".$res['kd_lokasi']."'"));

	?>
	<tr>
		<td align="center"><?php echo $res['row'];?></td>
		<td>
			<?php 
			$urlRak    = "mid=msrak&kd_lokasi=".$res['kd_lokasi'];
			$urlRakEnc = $edc->encrypt($urlRak,true);
			echo "<a href='main.php?".$urlRakEnc."'>".$res['kd_lokasi']."</a> ";
		?></td>
		<td><?php echo $res['lokasi'];?></td>
		<td><?php echo $res['alamat'];?></td>
		<td><?php echo $res['status']."&nbsp;<img src='images/".$res['icon']."' width=15px height=15px>";?></td>
		<td><?php echo $res['input_date']." | ".infouser($res['input_user']);?></td>
		<td align="right">

		<?php

		$delete_off 	= "<input class='btn btn-outline btn-danger btn-xs disabled gelap' type=button value=Hapus>";
		$edit_off   	= "<input class='btn btn-outline btn-success btn-xs disabled gelap' type=button value='Ubah'>";
		$approve_off 	= "<input class='btn btn-outline btn-primary btn-xs disabled gelap' type=button value='Approve Data'>";

		$urlEdit    = "mid=editlokasi&id=".$res['id_lokasi'];
		$urlEditEnc = $edc->encrypt($urlEdit,true);
	
		$edit_on 		= "<a style='text-decoration:none;' style='text-decoration:none;' href='main.php?".$urlEditEnc."'>
				<input class='btn btn-outline btn-success btn-xs' type=button value='Ubah'></a>";
		$delete_on 		= "<a style='text-decoration:none;' style='text-decoration:none;' href=javascript:confirmDelete('execute/exc_master.php?act=dellokasi&id=".$res['id_lokasi']."')><input class='btn btn-outline btn-danger btn-xs' type=button value='Hapus'></a>";
		$approve_on 	= "<a style='text-decoration:none;' style='text-decoration:none;' href=javascript:confirmApprove('execute/exc_master.php?act=approve_lokasi&id=".$res['id_lokasi']."')><input class='btn btn-outline btn-primary btn-xs' type=button value='Approve Data'></a>";


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
			//jika yang login  admin / pic bisa approve jg
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
        <p style="font-size:12px"> jika data lokasi bertanda seperti ini '<i style='color:#02c42e;'>active</i>' pada kolom aksi artinya data tersebut telah digunakan atau dikaitkan pada Data Arsip.</p>
    </div>
</div>
</div>