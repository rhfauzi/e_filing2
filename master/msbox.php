<?php

if($param1 == 'kd_lokasi' && $param2 == 'kd_rak'){
	$filt_lok 		= " AND kd_lokasi ='".$isiParam1."'";
	$filt_rak 		= " AND kd_rak ='".$isiParam2."'";
	$button_back 	= "<input class='btn btn-primary' type='button' value='Kembali' onclick='window.history.back(-1)'>";
	$forPaging   	= "&kd_lokasi=".$isiParam1."&kd_rak=".$isiParam2;
	$var_tpages     = $isiParam3;
	$var_adjacents	= $isiParam4;
	$info 			= "di lokasi No ".$isiParam1." & Rak No ".$isiParam2;
}else{
	$filt_lok 		= '';
	$filt_rak 		= '';
	$button_back 	= "";
	$forPaging 		= "";
	$var_tpages     = $isiParam1;
	$var_adjacents	= $isiParam2;
	$info 			= "";
}

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
<h3 align="center" style='font-family:monospace;color:#777;'>Data Box Arsip <?php echo $info; ?></h3>
<div style="float:right;">
<?php
if($level =='8'){
	$url    = "mid=addbox";
	$urlEnc = $edc->encrypt($url,true);
	echo "<a id='tambah' href='main.php?".$urlEnc."'><input class='btn btn-primary' type=button value='Tambah Box'></a> ";
	echo $button_back;
}
?>

</div>

<div><i class="ketmenu">Master <i class="fa fa-arrow-right"></i>&nbsp; Master Box</i></div><br>

<?php

	//-------------- variabel for paging-----------
	$halaman=$_GET['page'];
	if(empty($halaman)){
	$posisi=0;
	$halaman=1;
	$batas=20;
	}
	else{
		$batas =20;
		$posisi=($halaman - 1) * $batas;
		$batas=$batas * $halaman;
	}
	//---------------------------------------------

	$func_que_box = mainque_tbbox();

	$QueMain = "SELECT a.*,b.data_status as status,b.icon,ROW_NUMBER() over(order by a.id_box desc) as row 
				FROM (".$func_que_box.") as a, msdata_status b
				WHERE a.data_status = b.kode_datastatus
				$filt_lok $filt_rak";

	$QueRow     = "SELECT * FROM($QueMain) as x 
					WHERE row > $posisi and row <= $batas
					ORDER by x.id_box desc";

	//echo $QueMain;
	//echo $QueRow;					

	$Query 		= mssql_query($QueRow);
	$CekCount   = mssql_num_rows(mssql_query($QueRow));

	if($CekCount > 0){

	?>

	<table width="100%" border="0px">
	<tr>
	<td>
	<?php
		
	while($res	=	mssql_fetch_assoc($Query)){

	// query tidak menggunakan function karena hanya kdbox sementara kdbox ada didalam table arsip
	$cekarsip = mssql_num_rows(mssql_query("SELECT * FROM arsip WHERE kd_box = '".$res['kd_box']."'"));


	$delete_off 	= "<input class='btn btn-outline btn-danger btn-xs disabled gelap' type=button value=Hapus>";
	$edit_off   	= "<input class='btn btn-outline btn-warning btn-xs disabled gelap' type=button value='Ubah'>";
	$approve_off 	= "<input class='btn btn-outline btn-primary btn-xs disabled gelap' type=button value='Approve Data'>";

	$urlEdit    = "mid=editbox&id=".$res['id_box'];
	$urlEditEnc = $edc->encrypt($urlEdit,true);

	$edit_on 		= "<a style='text-decoration:none;' href='main.php?".$urlEditEnc."'>
			<input class='btn btn-outline btn-warning btn-xs' type=button value='Ubah'></a>";
	$delete_on 		= "<a style='text-decoration:none;' href=javascript:confirmDelete('execute/exc_master.php?act=delbox&id=".$res['id_box']."')><input class='btn btn-outline btn-danger btn-xs' type=button value='Hapus'></a>";
	$approve_on 	= "<a style='text-decoration:none;' href=javascript:confirmApprove('execute/exc_master.php?act=approve_box&id=".$res['id_box']."')><input class='btn btn-outline btn-primary btn-xs' type=button value='Approve Data'></a>";

	?>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-orangetwo">
		    <div class="panel-heading">
		        <div class="row">
		            <div class="col-xs-3">
		                <i class="fa fa-archive fa-5x"></i>
		            </div>
		            <div class="col-xs-9 text-right">
		       			<table border="0px" width="100%">
		            	<tr>
						<td>&nbsp;&nbsp;&nbsp;</td>
		       			<td width="70%">
		            	<font style="font-size:20px"><?php echo $cekarsip; ?></font></font>
		            	</td>
		            	<td>&nbsp;Arsip</td>
		            	</tr>
						<tr>
							<td></td>						
							<td style='font-size:10px;height:50px;color:#428bca;' colspan='3'>
							<?php if($res['deskripsi'] == '' || $res['deskripsi'] == ' '){echo "FILE ARSIP";}else{echo $res['deskripsi'];}?>
							</td>
						</tr>
		            	<tr>
		            		<td colspan="3" style="vertical-align: bottom;" >
		            			<?php echo "<i>".$res['input_date']."</i>";?></td>
		            	</tr>
		            	</table>
		            </div>
		        </div>
		    </div>
		     <div class="panel-body">
		        <div class="row">
		            <div class="col-xs-12 text-left">
		            	<?php
		            // jika yang login approver supervisor/manager/general
					if($level == '3' || $level == '4' || $level == '5'){
						if($res['data_status'] != 'A'){
							$active = "";
							echo $edit_off."&nbsp;";
							echo $delete_on."&nbsp;";
							echo $approve_on."&nbsp;";
						}else{
							$active = "";
							echo $edit_off."&nbsp;";
							echo $delete_off."&nbsp;";
							echo $approve_off."&nbsp;";
						}

						if($cekarsip > 0 )	{
							$active = "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
						}
					//jika yang login admin / pic bisa approve jg
					}elseif($level =='8'){
						if($res['data_status'] != 'A'){
							if($cekarsip > 0 )	{
								$active = "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
								echo $edit_off."&nbsp;";
								echo $delete_off."&nbsp;";
								echo $approve_off."&nbsp;";
							}else{
								$active = "";
								echo $edit_on."&nbsp;";
								echo $delete_on."&nbsp;";
								echo $approve_on."&nbsp;";
							}
							
						}else{
							if($cekarsip > 0 ){
								$active = "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
							}else{
								$active = "";
							}
							echo $edit_off."&nbsp;";
							echo $delete_off."&nbsp;";
							echo $approve_off."&nbsp;";
						}
					//jika yang login super admin
					}elseif($level =='1'){
						if($res['data_status'] != 'A'){
							if($cekarsip > 0 )	{
								$active = "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
								echo $edit_off."&nbsp;";
								echo $delete_off."&nbsp;";
								echo $approve_off."&nbsp;";
							}else{
								$active = "";
								echo $edit_on."&nbsp;";
								echo $delete_on."&nbsp;";
								echo $approve_on."&nbsp;";
							}
							
						}else{
							if($cekarsip > 0 ){
								$active = "<div style='float:left;'><i style='color:#02c42e;'>active</i></div>";
							}else{
								$active = "";
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
					</div>
				</div>
			</div>
				<div class="panel-footer">
			        <div class="row">
			            <div class="col-xs-12 text-left">
			                <div>
								<?php
								$urlDetail    = "mid=box_detail&kd_box=".$res['kd_box'];
								$urlDetailEnc = $edc->encrypt($urlDetail,true);
								echo "<a href='main.php?".$urlDetailEnc."'>";
								?>
			                	
			                	<font style="color:#428bca;">
			                	Box <?php echo $res['kd_lokasi']." / ".$res['kd_rak']." / ".$res['kd_box'].""?>
			                	<div style="float:right;"><?php echo $active; ?></div>
			                	</font>
			                	</a>
			                </div>

			            </div>
			        </div>
				</div>
		</div>
	</div>	
	<?php
	}
	?>
	</td>
	</tr>

	<tr>
	<td>

<?php	

//----------------------------------- additional paging -----------------------------
$jmldata=mssql_num_rows(mssql_query($QueMain));
$jmlhal=ceil($jmldata/20);

$page   = intval($_GET['page']);
$tpages = ($var_tpages) ? intval($var_tpages) : $jmlhal; 
$adjacents  = intval($var_adjacents);

if($page<=0)  $page  = 1;
if($adjacents<=0) $adjacents = 4;

$urlPage    = "mid=msbox".$forPaging."&tpages=" . $tpages . "&amp;adjacents=" . $adjacents;
$urlPageEnc = $edc->encrypt($urlPage,true);

$reload = $_SERVER['PHP_SELF'] . "?".$urlPageEnc;
	
	$prevlabel = "&lsaquo; Prev";
	$nextlabel = "Next &rsaquo;";
	
	$out = "<div class=\"pagin\">\n";
	
	// previous
	if($page==1) {
		$out.= "<span class='page active'>" . $prevlabel . "</span>\n";
	}
	elseif($page==2) {
		$out.= "<a class='page gradient' href=\"" . $reload . "\">" . $prevlabel . "</a>\n";
	}
	else {
		$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . ($page-1) . "\">" . $prevlabel . "</a>\n";
	}
	
	// first
	if($page>($adjacents+1)) {
		$out.= "<a class='page gradient' href=\"" . $reload . "\">1</a>\n";
	}
	
	// interval
	if($page>($adjacents+2)) {
		$out.= "...\n";
	}
	
	// pages
	$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	for($i=$pmin; $i<=$pmax; $i++) {
		if($i==$page) {
			$out.= "<span class=\"page active\">" . $i . "</span>\n";
		}
		elseif($i==1) {
			$out.= "<a class='page gradient' href=\"" . $reload . "\">" . $i . "</a>\n";
		}
		else {
			$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a>\n";
		}
	}
	
	// interval
	if($page<($tpages-$adjacents-1)) {
		$out.= "...\n";
	}
	
	// last
	if($page<($tpages-$adjacents)) {
		$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $tpages . "</a>\n";
	}
	
	// next
	if($page<$tpages) {
		$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . ($page+1) . "\">" . $nextlabel . "</a>\n";
	}
	else {
		$out.= "<span class='page active'>" . $nextlabel . "</span>\n";
	}
	echo "<div class='page gradient total' style='float:right;'>Total ".$jmldata."</div>";
	$out.= "</div>";

	
	echo $out;

	//-------------------------------------------------------------------------------------------
    ?>
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
        <p style="font-size:12px"> jika data box bertanda seperti ini '<i style='color:#02c42e;'>active</i>' pada kolom aksi artinya data tersebut telah digunakan atau dikaitkan pada Data Arsip.</p>
    </div>
</div>
</div>

	<?php
	}else{
	?>
	<br>
	<div class="col-lg-13">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body" align="center">
	       <h3 style="color:#a09e9e;">Mohon Maaf Data Masih Kosong</h3>
	       <br>
	       <img src='images/emptyicon.png' width="20%" height="20%">
	    </div>
	</div>
	</div>
	<?php	
	}
	?>


