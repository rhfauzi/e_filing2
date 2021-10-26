<?php

$kd_lokasi 	= $isiParam1;
$kd_rak 	= $isiParam2; 

if($param1 == 'kd_lokasi' && $param2 == 'kd_rak'){
	$filt_lok 		= " AND kd_lokasi ='".$kd_lokasi."'";
	$filt_rak 		= " AND kd_rak ='".$kd_rak."'";
	$forPaging   	= "&kd_lokasi=".$isiParam1."&kd_rak=".$isiParam2;
	$var_tpages     = $isiParam3;
	$var_adjacents	= $isiParam4;
}else{
	$filt_lok 		= '';
	$filt_rak 		= '';
	$forPaging   	= "";
	$var_tpages     = $isiParam1;
	$var_adjacents	= $isiParam2;
}
?>

<h3>Pemindahan Box</h3>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pemindahan <i class="fa fa-arrow-right"></i>&nbsp; Pemindahan Box</i></div><br>

<div class="panel panel-default">
<div class="panel-heading">Form Tambah Pemindahan Box (<i><b>step 2</b></i>)
	<div style="float:right;">
		<?php
		$url1   = "mid=menupindah";$urlEnc1 = $edc->encrypt($url1,true);
		$url2   = "mid=addpindah_box&kd_lokasi=".$kd_lokasi."";$urlEnc2 = $edc->encrypt($url2,true);
		echo "<a id='tambah' href='main.php?".$urlEnc1."'><input class='btn btn-info btn-sm' type=button value='Menu Pemindahan'></a>";
		echo "&nbsp";
		echo "<a href='main.php?".$urlEnc2."'><input class='btn btn-info btn-sm' type=button value='Kembali'></a>";
		?>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<?php

	//-------------- variabel for paging-----------
	$halaman=$_GET['page'];
	if(empty($halaman)){
	$posisi=0;
	$halaman=1;
	$batas=12;
	}
	else{
		$batas =12;
		$posisi=($halaman - 1) * $batas;
		$batas=$batas * $halaman;
	}
	//---------------------------------------------

	$QueMain = "SELECT a.*,b.data_status as status,b.icon,ROW_NUMBER() over(order by a.id_box desc) as row 
				FROM (".$func_que_box.") as a, msdata_status b
				WHERE a.data_status = b.kode_datastatus
				AND a.data_status = 'A' 
				$filt_lok $filt_rak";

	$QueRow     = "SELECT * FROM($QueMain) as x 
					WHERE row > $posisi and row <= $batas
					ORDER by x.id_box desc";

	$Query 		= mssql_query($QueRow);

	$CekCount   = mssql_num_rows(mssql_query($QueRow));

	if($CekCount > 0){

	?>

	<table width="100%" border="0px">
	<tr>
	<td>
	<?php
		
	while($res	=	mssql_fetch_assoc($Query)){

	$cekarsip = mssql_num_rows(mssql_query("SELECT * FROM arsip WHERE kd_box = '".$res['kd_box']."'"));

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
		       			<td width="70%">
		            	<font style="font-size:20px"><?php echo $cekarsip; ?></font>
		            	</td>
		            	<td>Arsip</td>
		            	</tr>
		            	<tr>
		            		<td colspan='2'>
		            		<?php
							$url3    = "mid=addpindah_box_last&kd_lokasi=".$kd_lokasi."&kd_rak=".$kd_rak."&kd_box=".$res['kd_box'];
							$urlEnc3 = $edc->encrypt($url3,true);
		            		echo"
		            		<a style='text-decoration:none;' href='main.php?".$urlEnc3."'>";
		            		?>
						<input class='btn btn-outline btn-primary btn-xs' type=button value='Pindahkan'></a>
		            		</td>
		            	</tr>
		            	</table>
		            </div>
		        </div>
		    </div>
		     
				<div class="panel-footer">
			        <div class="row">
			            <div class="col-xs-12 text-left">
			                <div style="color:#888787">
			                	<b>Box</b> <?php echo $res['kd_lokasi']." / ".$res['kd_rak']." / <b>".$res['kd_box']."</b>";?>
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
$jmlhal=ceil($jmldata/12);


$page   = intval($_GET['page']);
$tpages = ($var_tpages) ? intval($var_tpages) : $jmlhal; 
$adjacents  = intval($var_adjacents);

if($page<=0)  $page  = 1;
if($adjacents<=0) $adjacents = 4;

$urlPage    = "mid=addpindah_box_next&kd_lokasi=".$kd_lokasi."&kd_rak=".$kd_rak."&tpages=" . $tpages . "&amp;adjacents=" . $adjacents;
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

</div></div></div></div>
<br>
<div class="col-lg-13">
<div class="panel panel-info">
    <div class="panel-heading">
        Informasi
    </div>
    <div class="panel-body">
      ~ Pilih Box yang akan dipindahkan
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
	       <br><br>
	       ~ Mohon input data box pada menu master box terlebih dahulu ditujukan untuk rak ini agar terdapat pilihan box untuk memasukan arsip pada rak yang telah ditentukan.
	    </div>
	</div>
	</div>
	<?php	
	}
	?>


