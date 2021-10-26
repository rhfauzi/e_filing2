<?php
$kd_box = $isiParam1;

?>
<h3>Box Detail</h3>
<div style="float:right;">
<?php
// $url    = "mid=addbox";
// $urlEnc = $edc->encrypt($url,true);
// echo "<a id='tambah' href='main.php?".$urlEnc."'><input class='btn btn-primary' type=button value='Tambah Box'></a> ";
echo "<input class='btn btn-primary' type='button' value='Kembali' onclick='window.history.back(-1)'>";
?>

</div>

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Box <i class="fa fa-arrow-right"></i>&nbsp;Box Detail</i></div><br>
<?php

	$QueMain1 = "SELECT a.*,b.data_status,c.kd_lokasi,d.lokasi,b.icon 
					FROM msbox a, msdata_status b ,msrak c,mslokasi d
					WHERE a.data_status = b.kode_datastatus 
					AND a.kd_rak = c.kd_rak
					AND c.kd_lokasi = d.kd_lokasi
					AND a.kd_box = '".$kd_box."'";

	//echo $QueMain1;

	$Query1 = mssql_query($QueMain1);

	?>
	<table width="100%" border="0px" class="table">
	<tr>
	<td style="vertical-align: top;" width="10%">
	<?php
		
	$res1			= mssql_fetch_assoc($Query1);

	$kd_lokasi 		= $res1['kd_lokasi'];
	$kd_rak 		= $res1['kd_rak'];
	

	$QueMain2 = "SELECT a.*,b.usernamePegawai, ROW_NUMBER() over (order by id_arsip) as row 
					FROM arsip a,aplikasi.dbo.user_aplikasi b
					where a.input_user = b.id_pegawai
					AND kd_box = '".$kd_box."'";

	$count_arsip	=	mssql_num_rows(mssql_query($QueMain2));

	//echo $QueMain2;

	?>
	<div class="col-lg-12 col-md-6">
		<div class="panel panel-orangetwo">
		    <div class="panel-heading">
		        <div class="row">
		            <div class="col-xs-3">
		                <i class="fa fa-archive fa-5x"></i>
		            </div>
		        </div>
		    </div>
		     <div class="panel-footer">
		        <div class="row">
		            <div class="col-xs-12 text-left">
		            	<table border="0px" width="100%" class="table" style="color:#3B438D;">
		            		<tr>
		            			<td align="center">
		            				<b>Jumlah Arsip</b>
		            			</td>
							</tr>
							<tr>
		            			<td align="center">
		            				<?php echo $count_arsip; ?>
		            			</td>
		            		</tr>
		            		<tr>
		            			<td align="center" style='cursor:pointer;' title='<?php echo $res1['lokasi']; ?>'>
								<b>Kode Lokasi</b>
		            			</td>
							</tr>
							<tr>
		            			<td align="center" style='cursor:pointer;' title='<?php echo $res1['lokasi']; ?>'>
		            				<?php echo $kd_lokasi; ?>
		            			</td>
		            		</tr>
		            		<tr>
		            			<td align="center">
								<b>Kode Rak</b>
		            			</td>
							</tr>
							<tr>
		            			<td align="center">
		            				<?php echo $kd_rak; ?>
		            			</td>
		            		</tr>
							<?php if($res1['deskripsi'] == NULL){$box = "tidak ada deskripsi";}else{$box = $res1['deskripsi'];}?>
		            		<tr>
		            			<td align="center" style='cursor:pointer;' title='<?php echo $box; ?>'>
								<b>Kode Box</b>
		            			</td>
							</tr>
							<tr>
		            			<td align="center" style='cursor:pointer;' title='<?php echo $box; ?>'>
		            				<?php echo $kd_box; ?>
		            			</td>
		            		</tr>
		            	</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
	</td>
	<td>
		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th width="3%">No</th>
				<th width="20%">Kode / Nama Arsip</th>
				<th width="5%">Kategori</th>
				<th width="8%">Unit Kerja</th>
				<th width="15%">Input Log</th>


			</tr>
		</thead>
		<tbody>
			<?php
				$no=1;
				$Query2 	= mssql_query($QueMain2);

				while($res2	=	mssql_fetch_assoc($Query2)){

			?>
			<tr>
				<td align="center"><?php echo $res2['row'];?></td>
				<td><?php 
					$urlDetail    = "mid=listarsip_detail&kd_arsip=".$res2['kd_arsip']."";
					$urlDetailEnc = $edc->encrypt($urlDetail,true);
					echo "<a href='main.php?".$urlDetailEnc."'></i>".$res2['kd_arsip']."</a>";
					?>
					<?php echo $res2['nama_arsip'];?>
				</td>
				<td><?php echo $res2['kd_kategori'];?></td>
				<td><?php echo $res2['kd_uker'];?></td>
				<td><?php echo $res2['usernamePegawai']."|".$res2['input_date'];?></td>
			</tr>
			<?php
			}
			?>
		</tbody>
		</table>
	</td>
	</tr>
</table>
<br>
<div class="col-lg-13">
<div class="panel panel-info">
    <div class="panel-heading">
        Informasi
    </div>
    <div class="panel-body">
        <p style="font-size:12px">menu ini untuk melihat arsip - arsip pada box tertentu yang telah dipilih</p>
    </div>
</div>
</div>
