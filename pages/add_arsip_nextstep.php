<?php
$kd_lokasi 	= $_GET['kd_lokasi'];
$kd_rak 	= $_GET['kd_rak'];
?>

<br>
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">Form Tambah Arsip (<i><b>step 2</b></i>)
	<div style="float:right;">
			<!-- <input class="btn btn-info btn-sm" type=button value='Kembali' onclick="window.history.back(-1)"> -->
			<a href='main.php?mid=msbox'><input class="btn btn-info btn-sm" type=button value='Data Arsip'></a>
			<?php 
			echo "<a href='main.php?mid=addarsip&kd_lokasi=".$kd_lokasi."'><input class='btn btn-info btn-sm' type=button value='Kembali'></a>";
			?>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div>
	<i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Tambah Arsip <i class="fa fa-arrow-right"></i> Pilih Box </i>
	<div style="float: right;margin-right: 20px;"><?php echo "Kode Rak : <b>".$kd_rak."</b>"; ?></div>
</div>
<br>
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

	$QueMain = "SELECT id_box,kd_lokasi,kd_rak,kd_box,ROW_NUMBER() over (order by id_box desc) as row 
				FROM (".$func_que_box.") as a
				WHERE data_status = 'A' AND kd_lokasi = '".$kd_lokasi."' AND kd_rak = '".$kd_rak."'";

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

	while ($resbox = mssql_fetch_array($Query)){

	// query tidak menggunakan function karena hanya kdbox sementara kdbox ada didalam table arsip
	$que_count 		= "SELECT count(*) as jumlah FROM arsip WHERE kd_box = '".$resbox['kd_box']."'";

	$sum_archive 	= mssql_fetch_assoc(mssql_query($que_count));

	?>
	<div class="col-lg-3 col-md-6">
		<?php echo "<a href='main.php?mid=addarsip_laststep&kd_lokasi=".$resbox['kd_lokasi']."&kd_rak=".$resbox['kd_rak']."&kd_box=".$resbox['kd_box']."'>";?>
		<div class="panel panel-orangetwo">
		    <div class="panel-heading">
		        <div class="row">
		            <div class="col-xs-3">
		                <i class="fa fa-archive fa-5x"></i>
		            </div>
		            <div class="col-xs-9 text-right">
		            	<font style="font-size:20px"><?php echo $sum_archive['jumlah']; ?></font></font><br>
		            	Arsip
		            </div>
		        </div>
		    </div>
		    <div class="panel-footer">
		        <div class="row">
				    <div class="col-xs-12 text-left">
				            <div>Box No. <?php echo $resbox['kd_box']?></div>
				    </div>
				</div>
			</div>
		</div>
		</a>
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
$tpages = ($_GET['tpages']) ? intval($_GET['tpages']) : $jmlhal; 
$adjacents  = intval($_GET['adjacents']);

if($page<=0)  $page  = 1;
if($adjacents<=0) $adjacents = 4;

$reload = $_SERVER['PHP_SELF'] . "?mid=addarsip_nextstep&kd_lokasi=".$kd_lokasi."&kd_rak=".$kd_rak."&tpages=" . $tpages . "&amp;adjacents=" . $adjacents;
	
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
	echo "<div class='page gradient' style='float:right;'>Total ".$jmldata."</div>";
	$out.= "</div>";

	
	echo $out;

	//-------------------------------------------------------------------------------------------
    ?>
	</td>
	</tr>
</table>
<br>
</div>
</div>
</div>
</div>


	<div class="col-lg-13">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body" align="justify">
	        <p style="font-size:12px">
	        	~ Kotak berwarna orange adalah daftar <b>Kode Box </b> yang muncul ketika rak dipilih. Jika tidak ada daftar box yang muncul, artinya didalam rak tersebut belum terdapat <b>Box</b> atau belum diinput datanya.<br>
	        	~ Setelah muncul kotak orange dengan beberapa pilihan <b> Kode Box</b> pilih dan klik kotak tersebut untuk menuju ke halaman selanjutnya yaitu menuju halaman form utama tambah data arsip.
	        </p>
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
	//echo $QueRow;
	}
	?>

