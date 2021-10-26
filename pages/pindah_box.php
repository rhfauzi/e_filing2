<script type="text/javascript" src="js/jquery-1.4.js"></script> 	


<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($param1 == 'alert')
{	
	if($isiParam1 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS !</strong> Data berhasil disimpan. 
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>DENIED !</strong> mohon maaf, Data gagal disimpan mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------
?>
<h3>Pemindahan Box</h3>

<div style="float:right;">
<?php

$url1   = "mid=addpindah_box";$urlEnc1 = $edc->encrypt($url1,true);
$url2   = "mid=menupindah";$urlEnc2 = $edc->encrypt($url2,true);

if(in_array($level,$arr_group_editor)){ //jika level admin dan super admin
echo "<a id='tambah' href='main.php?".$urlEnc1."'><input class='btn btn-primary' type=button value='Tambah Data'></a>";
}
echo "&nbsp";
echo "<a id='button' href='main.php?".$urlEnc2."'><input class='btn btn-primary' type=button value='Menu Pemindahan'></a>";
echo "&nbsp";

?>
</div>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pemindahan <i class="fa fa-arrow-right"></i>&nbsp; Pemindahan Box</i></div><br>

<br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr>
		<th width="2%">No</th>
		<th width="8%">Kode Box</th>
		<th width="5%"><font style='color:blue;'>RL</font></th>
		<th width="5%"><font style='color:blue;'>RB</font></th>
		<th width="8%">Tgl Pindah</th>
		<th width="20%">Alasan Pindah</th>
	</tr>
</thead>
<tbody>
	<?php
	$no =1;

		$QueMain	=	mssql_query("SELECT a.*,b.alasan FROM hist_pindah_box a,msalasan_pindah b where a.alasan_pindah=b.kode_alasan");
		
		while($res	=	mssql_fetch_assoc($QueMain)){

	?>
	<tr>
		<td align="center"><?php echo $no;?></td>
		<td><?php echo $res["kd_box"]; ?></td>
		<td><?php echo $res['rak_awal'];?></td>
		<td><?php echo $res['rak_akhir'];?></td>
		<td><?php echo DBDate_picker($res['tgl_pindah']);?></td>
		<td><?php echo $res['alasan'];?></td>
		
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
	    <div class="panel-body">
	        <p style="font-size:12px">
	        	~ Menu pemindahan box digunakan untuk melihat history data pemindahan box<br>
	        	~ 	<font style='color:green;'><b>RL</b></font> = Rak Lama,
					<font style='color:green;'><b>RB</b></font> = Rak Baru
	        </p>
	    </div>
	</div>
</div>

<br>