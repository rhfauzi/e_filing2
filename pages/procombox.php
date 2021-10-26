<?php
require '../setting/koneksi.php';
require '../function/check.php';
require '../function/encdec.php';
conDB('.','e_filing');

$edc = new encdec();

$act = $_GET['act'];

// pemanggilan query function perlu dijabarkan di file proses karena file proses tidak ada pada halaman
// jika file muncul di halaman atau ada interface maka pemanggilan ini ada di file utama main.php
$func_que_arsip 	= mainque_tbarsip();
$func_que_box 		= mainque_tbbox();
$func_count_arsip 	= countque_tbarsip();
$func_count_box 	= countque_tbbox();
//====================================================================================================

//------------------------------------------ UNTUK SELECT TYPE BERDASARKAN KATEGORI ------------------------------

if($act == 'kotak_rak'){

	$kd_lokasi = $_GET['kd_lokasi'];


	// //-------------- variabel for paging-----------
	// $halaman=$_GET['page'];
	// if(empty($halaman)){
	// $posisi=0;
	// $halaman=1;
	// $batas=6;
	// }
	// else{
	// 	$batas =6;
	// 	$posisi=($halaman - 1) * $batas;
	// 	$batas=$batas * $halaman;
	// }
	// //---------------------------------------------

	// $QueMain = "SELECT id_rak,kd_lokasi,kd_rak,ROW_NUMBER() over (order by id_rak desc) as row  
	// 			FROM msrak WHERE data_status = 'A' AND kd_lokasi = '".$kd_lokasi."'";

	// $QueRow     = "SELECT * FROM($QueMain) as x 
	// 			WHERE row > $posisi and row <= $batas
	// 			ORDER by x.id_rak desc";

	// $Query = mssql_query($QueRow);


	$QueMain = "SELECT id_rak,kd_lokasi,kd_rak FROM msrak WHERE data_status = 'A' AND kd_lokasi = '".$kd_lokasi."'";

	$Query = mssql_query($QueMain);

	$CekCount   = mssql_num_rows(mssql_query($QueMain));

	if($CekCount > 0){
	
	?>

	<table width="100%" border="0px">
	<tr>
	<td>

	<?php
	while ($resrak = mssql_fetch_array($Query)){

	$kd_rak 	= $resrak['kd_rak'];	

	$que_count_box 	= "".$func_count_box." AND msbox.data_status = 'A' AND msrak.kd_rak = '".$kd_rak."'";
	$sum_box 		= mssql_fetch_assoc(mssql_query($que_count_box));

	$que_count_arsip= "".$func_count_arsip." AND msrak.kd_rak = '".$kd_rak."'";
	$sum_arsip 		= mssql_fetch_assoc(mssql_query($que_count_arsip));

	if($sum_box['jumlah'] > 0){
		$link = "main.php?mid=addarsip_nextstep&kd_lokasi=".$resrak['kd_lokasi']."&kd_rak=".$resrak['kd_rak']."";
		$clas = "class='panel panel-softblue'";
		$ket  = "";
	}else{
		$link = "#";
		$clas = "class='panel' style='color:#999;border-color:#999'";
		$ket  = "style='color:#999;'";
	}

	?>
	<div class="col-lg-3 col-md-6">
		<?php echo "<a href='".$link."'>";?>
		<div <?php echo $clas; ?>>
		    <div class="panel-heading">
		        <div class="row">
		            <div class="col-xs-3">
		                <i class="fa fa-tasks fa-4x"></i>
		            </div>
		            <div class="col-xs-9 text-right">
		            	<font style="font-size:20px"><?php echo $sum_box['jumlah']; ?></font></font>&nbsp;B<br>
		            	<font style="font-size:20px"><?php echo $sum_arsip['jumlah']; ?></font></font>&nbsp;A
		            </div>
		        </div>
		    </div>
		    <div class="panel-footer">
		        <div class="row">
		        	<div class="col-xs-12 text-left">
		                <div <?php echo $ket; ?>>Rak <?php echo $resrak['kd_lokasi']."/".$resrak['kd_rak']?></div>
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
	// //----------------------------------- additional paging -----------------------------
	// $jmldata=mssql_num_rows(mssql_query($QueMain));
	// $jmlhal=ceil($jmldata/6);


	// $page   = intval($_GET['page']);
	// $tpages = ($_GET['tpages']) ? intval($_GET['tpages']) : $jmlhal; 
	// $adjacents  = intval($_GET['adjacents']);

	// if($page<=0)  $page  = 1;
	// if($adjacents<=0) $adjacents = 4;

	// $reload = "main.php?mid=addarsip&kd_lokasi=".$kd_lokasi."&kd_rak=".$kd_rak."&tpages=" . $tpages . "&amp;adjacents=" . $adjacents;
	
	// $prevlabel = "&lsaquo; Prev";
	// $nextlabel = "Next &rsaquo;";
	
	// $out = "<div class=\"pagin\">\n";
	
	// // previous
	// if($page==1) {
	// 	$out.= "<span class='page active'>" . $prevlabel . "</span>\n";
	// }
	// elseif($page==2) {
	// 	$out.= "<a class='page gradient' href=\"" . $reload . "\">" . $prevlabel . "</a>\n";
	// }
	// else {
	// 	$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . ($page-1) . "\">" . $prevlabel . "</a>\n";
	// }
	
	// // first
	// if($page>($adjacents+1)) {
	// 	$out.= "<a class='page gradient' href=\"" . $reload . "\">1</a>\n";
	// }
	
	// // interval
	// if($page>($adjacents+2)) {
	// 	$out.= "...\n";
	// }
	
	// // pages
	// $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	// $pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	// for($i=$pmin; $i<=$pmax; $i++) {
	// 	if($i==$page) {
	// 		$out.= "<span class=\"page active\">" . $i . "</span>\n";
	// 	}
	// 	elseif($i==1) {
	// 		$out.= "<a class='page gradient' href=\"" . $reload . "\">" . $i . "</a>\n";
	// 	}
	// 	else {
	// 		$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a>\n";
	// 	}
	// }
	
	// // interval
	// if($page<($tpages-$adjacents-1)) {
	// 	$out.= "...\n";
	// }
	
	// // last
	// if($page<($tpages-$adjacents)) {
	// 	$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $tpages . "</a>\n";
	// }
	
	// // next
	// if($page<$tpages) {
	// 	$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . ($page+1) . "\">" . $nextlabel . "</a>\n";
	// }
	// else {
	// 	$out.= "<span class='page active'>" . $nextlabel . "</span>\n";
	// }
	// echo "<div class='page gradient' style='float:right;'>Total ".$jmldata."</div>";
	// $out.= "</div>";

	
	// echo $out;

	// //-------------------------------------------------------------------------------------------
	?>

	</td>
	</tr>
	</table>
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
	       ~ Mohon input data Rak pada menu master Rak terlebih dahulu ditujukan untuk Lokasi ini agar terdapat pilihan Rak untuk memasukan box dan arsip pada lokasi yang telah ditentukan.
	    </div>
	</div>
	</div>
	<?php	
	}
	?>
<?php
}



if($act == 'pindah_kotak_rak'){

	$kd_lokasi = $_GET['kd_lokasi'];


	$QueMain = "SELECT id_rak,kd_lokasi,kd_rak FROM msrak WHERE data_status = 'A' AND kd_lokasi = '".$kd_lokasi."'";

	$Query = mssql_query($QueMain);
	$CekCount   = mssql_num_rows(mssql_query($QueMain));

	if($CekCount > 0){
	
	?>

	<table width="100%" border="0px">
	<tr>
	<td>

	<?php
	while ($resrak = mssql_fetch_array($Query)){

	$kd_rak 	= $resrak['kd_rak'];	

	$que_count_box 	= "".$func_count_box." AND msbox.data_status = 'A' AND msrak.kd_rak = '".$kd_rak."'";
	$sum_box 		= mssql_fetch_assoc(mssql_query($que_count_box));

	$que_count_arsip= "".$func_count_arsip." AND msrak.kd_rak = '".$kd_rak."'";
	$sum_arsip 		= mssql_fetch_assoc(mssql_query($que_count_arsip));

	if($sum_box['jumlah'] > 0){
		$urlRakNext    = "mid=addpindah_rak_next&kd_lokasi=".$resrak['kd_lokasi']."&kd_rak=".$resrak['kd_rak'];
		$urlEncRakNext = $edc->encrypt($urlRakNext,true);

		$link = "main.php?".$urlEncRakNext;
		$clas = "class='panel panel-softblue'";
		$ket  = "";
	}else{
		$link = "#";
		$clas = "class='panel' style='color:#999;border-color:#999'";
		$ket  = "style='color:#999;'";
	}

	?>
	<div class="col-lg-3 col-md-6">
		<?php echo "<a href='".$link."'>";?>
		<div <?php echo $clas; ?>>
		    <div class="panel-heading">
		        <div class="row">
		            <div class="col-xs-3">
		                <i class="fa fa-tasks fa-4x"></i>
		            </div>
		            <div class="col-xs-9 text-right">
		            	<font style="font-size:20px"><?php echo $sum_box['jumlah']; ?></font></font>&nbsp;B<br>
		            	<font style="font-size:20px"><?php echo $sum_arsip['jumlah']; ?></font></font>&nbsp;A
		            </div>
		        </div>
		    </div>
		    <div class="panel-footer">
		        <div class="row">
		        	<div class="col-xs-12 text-left">
		                <div <?php echo $ket; ?>>Rak <?php echo $resrak['kd_lokasi']."/".$resrak['kd_rak']?></div>
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

	</td>
	</tr>
	</table>
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
	       ~ Mohon input data Rak pada menu master Rak terlebih dahulu ditujukan untuk Lokasi ini agar terdapat pilihan Rak untuk memasukan box dan arsip pada lokasi yang telah ditentukan.
	    </div>
	</div>
	</div>
	<?php	
	}
	?>
<?php
}



if($act == 'pindah_kotak_box'){

	$kd_lokasi = $_GET['kd_lokasi'];


	$QueMain = "SELECT id_rak,kd_lokasi,kd_rak FROM msrak WHERE data_status = 'A' AND kd_lokasi = '".$kd_lokasi."'";

	$Query = mssql_query($QueMain);
	$CekCount   = mssql_num_rows(mssql_query($QueMain));

	if($CekCount > 0){
	
	?>

	<table width="100%" border="0px">
	<tr>
	<td>

	<?php
	while ($resrak = mssql_fetch_array($Query)){

	$kd_rak 	= $resrak['kd_rak'];	

	$que_count_box 	= "".$func_count_box." AND msbox.data_status = 'A' AND msrak.kd_rak = '".$kd_rak."'";
	$sum_box 		= mssql_fetch_assoc(mssql_query($que_count_box));

	$que_count_arsip= "".$func_count_arsip." AND msrak.kd_rak = '".$kd_rak."'";
	$sum_arsip 		= mssql_fetch_assoc(mssql_query($que_count_arsip));

	if($sum_box['jumlah'] > 0){
		$urlBoxNext    = "mid=addpindah_box_next&kd_lokasi=".$resrak['kd_lokasi']."&kd_rak=".$resrak['kd_rak'];
		$urlEncBoxNext = $edc->encrypt($urlBoxNext,true);

		$link = "main.php?".$urlEncBoxNext;
		$clas = "class='panel panel-softblue'";
		$ket  = "";
	}else{
		$link = "#";
		$clas = "class='panel' style='color:#999;border-color:#999'";
		$ket  = "style='color:#999;'";
	}

	?>
	<div class="col-lg-3 col-md-6">
		<?php echo "<a href='".$link."'>";?>
		<div <?php echo $clas; ?>>
		    <div class="panel-heading">
		        <div class="row">
		            <div class="col-xs-3">
		                <i class="fa fa-tasks fa-4x"></i>
		            </div>
		            <div class="col-xs-9 text-right">
		            	<font style="font-size:20px"><?php echo $sum_box['jumlah']; ?></font></font>&nbsp;B<br>
		            	<font style="font-size:20px"><?php echo $sum_arsip['jumlah']; ?></font></font>&nbsp;A
		            </div>
		        </div>
		    </div>
		    <div class="panel-footer">
		        <div class="row">
		        	<div class="col-xs-12 text-left">
		                <div <?php echo $ket; ?>>Rak <?php echo $resrak['kd_lokasi']."/".$resrak['kd_rak']?></div>
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

	</td>
	</tr>
	</table>
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
	       ~ Mohon input data Rak pada menu master Rak terlebih dahulu ditujukan untuk Lokasi ini agar terdapat pilihan Rak untuk memasukan box dan arsip pada lokasi yang telah ditentukan.
	    </div>
	</div>
	</div>
	<?php	
	}
	?>
<?php
}




//------------------------------------------ UNTUK SELECT TYPE BERDASARKAN KATEGORI ------------------------------

// if($act == 'type'){

// 	$kd_kategori = $_GET['kd_kategori'];
// 	$showtype = mssql_query("SELECT kd_type,nm_type FROM mstype WHERE kd_kategori = '".$kd_kategori."'");
// 	while ($restype = mssql_fetch_array($showtype)){
// 	echo "<option value='".$restype['kd_type']."'>".$restype['kd_type']." - ".$restype['nm_type']."</option>";
// 	}
// }


//------------------------------------------ UNTUK SELECT TYPE BERDASARKAN lokasi ------------------------------

if($act == 'rak'){

	$kd_lokasi = $_GET['kd_lokasi'];
	$showlok = mssql_query("SELECT kd_lokasi,kd_rak FROM msrak WHERE kd_lokasi = '".$kd_lokasi."'");
	while ($reslok = mssql_fetch_array($showlok)){
	echo "<option value='".$reslok['kd_rak']."'>".$reslok['kd_rak']."</option>";
	}
}

if($act == 'rak2'){

	$getkode   = explode(" /",$_GET['kd_lokasi']);
	$kd_lokasi = $getkode[0];

	$showlok = mssql_query("SELECT kd_lokasi,kd_rak FROM msrak WHERE kd_lokasi = '".$kd_lokasi."' AND data_status = 'A'");
	echo "<option value='0'>~ Semua Rak ~</option>";
	while ($reslok = mssql_fetch_array($showlok)){
	echo "<option value='".$reslok['kd_rak']."'>".$reslok['kd_rak']."</option>";

	}
}


if($act == 'rak3'){

	$kd_lokasi = $_GET['kd_lokasi'];

	$showlok = mssql_query("SELECT kd_lokasi,kd_rak FROM msrak WHERE kd_lokasi = '".$kd_lokasi."'");
	echo "<option value='0'>~ Semua Rak ~</option>";
	while ($reslok = mssql_fetch_array($showlok)){
	echo "<option value='".$reslok['kd_rak']."'>".$reslok['kd_rak']."</option>";

	}

}

if($act == 'rak4'){

	$getkode   = explode(" /",$_GET['kd_lokasi']);
	$kd_lokasi = $getkode[0];

	$showlok = mssql_query("SELECT kd_lokasi,kd_rak FROM msrak WHERE kd_lokasi = '".$kd_lokasi."' AND data_status = 'A'");
	echo "<option value='0'>~ Pilih Rak ~</option>";
	while ($reslok = mssql_fetch_array($showlok)){
	echo "<option value='".$reslok['kd_rak']."'>".$reslok['kd_rak']."</option>";

	}
}


//------------------------------------------ UNTUK SELECT TYPE BERDASARKAN rak ------------------------------

if($act == 'box'){

	$kd_rak = $_GET['kd_rak'];
	$showbox = mssql_query("SELECT kd_box FROM msbox WHERE kd_rak = '".$kd_rak."'");
	echo "<option value='0'>~ Semua Box ~</option>";
	while ($resbox = mssql_fetch_array($showbox)){
	echo "<option value='".$resbox['kd_box']."'>".$resbox['kd_box']."</option>";
	}
}


if($act == 'box2'){

	$kd_rak = $_GET['kd_rak'];
	$showbox = mssql_query("SELECT kd_box,deskripsi FROM msbox WHERE kd_rak = '".$kd_rak."' AND data_status='A'");
	echo "<option value='0'>~ Pilih Box ~</option>";
	while ($resbox = mssql_fetch_array($showbox)){
	echo "<option value='".$resbox['kd_box']."'>".$resbox['kd_box']."-".$resbox['deskripsi']."</option>";
	}
}





//------------------------------------------ UNTUK LOOPING FORM DETAIL ------------------------------

if($act == 'form_detail'){

	$jumlah_detail = $_GET['jumlah_detail'];
	
	for($i=1;$i<=$jumlah_detail;$i++){

		echo "
		
			<tr><td colspan='5' style='text-align: center;background-color: #b4e0e7;color:#7e7e7e'>".$i."</td></tr>
			<tr colspan='5' height='10px'></tr>
			<tr>
				<td width='10%' style='padding-left: 30px;'>No Document</td>
				<td width='20%'><input type='text' id='no_doc".$i."' name='no_doc".$i."' class='form-control ukuran9' placeholder='Cth : ND/001/DIV/TSI/12/2018'></td>
				<td width='10%' style='padding-left: 30px;'>Tanggal Document</td>
				<td width='20%'>
				<div class='form-group input-group ukuran5' style='padding:10px 0 0 0;'>
				<span class='input-group-addon'><i class='fa fa-calendar-o'></i>
		        </span>
				<input type='text' id='tgl_doc".$i."' name='tgl_doc".$i."' placeholder='dd/mm/yyyy' readonly class='form-control ukuran3' style='background-color: #fff8bc;cursor: text;'>
				</div>
				</td>
			</tr>
			<tr>
				<td style='padding-left: 30px;'>Dari</td>
				<td><input type='text' id='dari".$i."' name='dari".$i."' class='form-control ukuran9' placeholder='Cth : Divisi TSI'></td>
				<td style='padding-left: 30px;'>Kepada</td>
				<td><input type='text' id='kepada".$i."' name='kepada".$i."' class='form-control ukuran9' placeholder='Cth : Divisi Logistik'></td>
			</tr>
			<tr colspan='5' height='20px'></tr>
		";
	}
}

?>

<script type="text/javascript" src="..js/jquery-1.4.js"></script> 	

<script type='text/javascript'>

	$(document).ready(function(){ 

		var year = (new Date()).getFullYear() + 10

		var i;

		for(i=1;i<=10;i++)
		{
			$("#tgl_doc"+i).datepicker({
				// dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year,minDate: -30 
				dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year

			});
		}

	});
</script>