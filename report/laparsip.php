<?php
	if($_POST['kd_kategori'] != ''){
		$kd_kategori	=	$_POST['kd_kategori'];
	}elseif($_GET['kd_kategori'] != ''){
		$kd_kategori	=	$_GET['kd_kategori'];
	}else{
		$kd_kategori	=	"";
	}

	if($_POST['kd_uker'] != ''){
		$kd_uker	=	$_POST['kd_uker'];
	}elseif($_GET['kd_uker'] != ''){
		$kd_uker	=	$_GET['kd_uker'];
	}else{
		$kd_uker	=	"";
	}

	if($_POST['kd_lokasi'] != ''){
		$kd_lokasi	=	$_POST['kd_lokasi'];
	}elseif($_GET['kd_lokasi'] != ''){
		$kd_lokasi	=	$_GET['kd_lokasi'];
	}else{
		$kd_lokasi	=	"";
	}

	if($_POST['kd_rak'] != ''){
		$kd_rak	=	$_POST['kd_rak'];
	}elseif($_GET['kd_rak'] != ''){
		$kd_rak	=	$_GET['kd_rak'];
	}else{
		$kd_rak	=	"";
	}

	if($_POST['kd_box'] != ''){
		$kd_box	=	$_POST['kd_box'];
	}elseif($_GET['kd_box'] != ''){
		$kd_box	=	$_GET['kd_box'];
	}else{
		$kd_box	=	"";
	}

	if($_POST['tgl_awal'] != ''){
		$tgl_awal	=	$_POST['tgl_awal'];
	}elseif($_GET['tgl_awal'] != ''){
		$tgl_awal	=	$_GET['tgl_awal'];
	}else{
		$tgl_awal	=	"";
	}

	if($_POST['tgl_akhir'] != ''){
		$tgl_akhir	=	$_POST['tgl_akhir'];
	}elseif($_GET['tgl_akhir'] != ''){
		$tgl_akhir	=	$_GET['tgl_akhir'];
	}else{
		$tgl_akhir	=	"";
	}

	//-------------- variabel for paging-----------
	$halaman=$_GET['page'];
	if(empty($halaman)){
	$posisi=0;
	$halaman=1;
	$batas=100;
	}
	else{
		$batas =100;
		$posisi=($halaman - 1) * $batas;
		$batas=$batas * $halaman;
	}
	//---------------------------------------------

	if($kd_kategori == '0'){$fkategori = ""; $ikategori = "Semua Kategori";}
	else{
	$fkategori 		= "AND a.kd_kategori = '".$kd_kategori."' "; 
	$ikategori 		= "(".$kd_kategori.")";
	}

	if($kd_uker == '0'){$fuker = ""; $iuker = "Semua Uker";}
	else{
	$fuker 		= "AND a.kd_uker = '".$kd_uker."' "; 
	$iuker 		= "(".$kd_uker.")";
	}

	// if($kd_type =='0'){$ftype = ""; $itype = "Semua Type";}
	// else{
	// $ftype 		= "AND a.kd_type = '".$kd_type."' ";
	// $get_type 	= mssql_fetch_array(mssql_query("SELECT * FROM mstype WHERE kd_type = '".$kd_type."'"));
	// $itype 		= "(".$kd_type.") ".$get_type['nm_type'];}


	if($kd_lokasi == '0' || $kd_lokasi == ''){$flokasi = ""; $ilokasi ="Semua Lokasi";}
	else{
	$flokasi 	= "AND a.kd_lokasi = '".$kd_lokasi."' "; 
	$get_lokasi	= mssql_fetch_array(mssql_query("SELECT * FROM mslokasi WHERE kd_lokasi = '".$kd_lokasi."'"));
	$ilokasi 	="(".$kd_lokasi.") ".$get_lokasi['lokasi'];}


	if($kd_rak == '0' || $kd_rak == ''){$frak = ""; $irak ="Semua Rak";}
	else{
	$frak 	= "AND a.kd_rak = '".$kd_rak."' "; 
	$get_rak	= mssql_fetch_array(mssql_query("SELECT * FROM msrak WHERE kd_rak = '".$kd_rak."'"));
	$irak 	="(".$kd_rak.") ".$get_rak['rak'];}


	if($kd_box == '0' || $kd_box == ''){$fbox = ""; $ibox ="Semua box";}
	else{
	$fbox 	= "AND a.kd_box = '".$kd_box."' "; 
	$get_box	= mssql_fetch_array(mssql_query("SELECT * FROM msbox WHERE kd_box = '".$kd_box."'"));
	$ibox 	="(".$kd_box.") ".$get_box['box'];}


	if($tgl_awal == ""){$ftgl_awal = ""; $itgl_awal = " - ";}
	else{$ftgl_awal = "AND a.tgl_masuk >= '".DBDate($tgl_awal)."' "; $itgl_awal = $tgl_awal;}
	if($tgl_akhir == ""){$ftgl_akhir = ""; $itgl_akhir =" - ";}
	else{$ftgl_akhir = "AND a.tgl_masuk <= '".DBDate($tgl_akhir)."' "; $itgl_akhir = $tgl_akhir;}

	$QueMain = "SELECT a.*,ROW_NUMBER() over(ORDER by a.id_arsip) as row 
				FROM (".$func_que_arsip.") as a
				WHERE 1 = 1 
					$fkategori
					$fuker
					$flokasi
					$frak
					$fbox
					$ftgl_awal
					$ftgl_akhir";

	$Que = "SELECT * FROM(".$QueMain.") as x WHERE row > $posisi and row <= $batas order by x.id_arsip asc";

	// echo "<br><br>";
	//echo $Que;
	$Sql	=	mssql_query($Que);

?>

<h3>Laporan Arsip</h3>
<div style="float:right;">
	<?php
	$url1 	= "mid=laparsip";
	$urlEnc1 = $edc->encrypt($url1,true);

	echo "<a style='text-decoration:none;' id='download' href='report/downex.php?type=exarsip&print=1&nm=RArsip&kd_kategori=".$kd_kategori."&kd_uker=".$kd_uker."&kd_lokasi=".$kd_lokasi."&kd_rak=".$kd_rak."&kd_box=".$kd_box."&tgl_awal=".$tgl_awal."&tgl_akhir=".$tgl_akhir."'>
		<input class='page gradient' type=button value='Download Excel'>
		</a>";
	echo "&nbsp;";
	echo "<a id='param' href='main.php?".$urlEnc1."'><input class='page gradient' type=button value='Parameter Laporan'></a>";
	?>	
	</div>

<div>Report <i class="icon-arrow-right"> </i>Laporan Arsip <i class="icon-arrow-right"> </i>Proses</div><br>
<table border="0px" width="50%">
	<tr><td>Kategori</td><td>=</td><td><?php echo $ikategori; ?></td></tr>
	<tr><td>Uker</td><td>=</td><td><?php echo $iuker; ?></td></tr>
	<tr><td>Lokasi</td><td>=</td><td><?php echo $ilokasi; ?></td></tr>
	<tr><td>Rak</td><td>=</td><td><?php echo $irak; ?></td></tr>
	<tr><td>Box</td><td>=</td><td><?php echo $ibox; ?></td></tr>
	<tr><td>Dari / Lebih dari tanggal</td><td>=</td><td><?php echo $itgl_awal; ?></td></tr>
	<tr><td>Sampai / Kurang dari tanggal</td><td>=</td><td><?php echo $itgl_akhir; ?></td></tr>
</table><br>
<table  class="datatable-1 table table-bordered table-striped display" width="100%">
<thead>
	<tr>
		<th>No</th>
		<th>Kode Arsip</th>
		<th>Kategori</th>
		<th>Lokasi/Rak/Box</th>
		<th>Nama Arsip</th>
		<th>Tgl Masuk</th>
	</tr>
</thead>
<tbody>
	<?php 
	while($res	=	mssql_fetch_assoc($Sql)){

	?>
	<tr>
		<td><?php echo $res['row'];?></td>
		<td>
		<?php 
		echo "<a target='_blank' href='main.php?mid=viewarsipdetail&id=".$res['id_arsip']."&x=1'>
		<i class='icon-search'></i> ".$res['kd_arsip']."</a> ";
		$icon_stat = mssql_fetch_assoc(mssql_query("SELECT icon FROM msdata_status WHERE kode_datastatus = '".$res['data_status']."'"));
		//echo "<img src='images/".$icon_stat['icon']."' width=15px height=15px>";
		?>
		</td>
		<td>
		<?php echo $res['kd_kategori'];?>
		</td>
		<td>
		<?php echo "".$res['kd_lokasi']." / ".$res['kd_rak']." / ".$res['kd_box'];?>
		</td>
		<td><?php echo $res['nama_arsip'];?></td>
		<td><?php echo ShortDate2($res['tgl_masuk']);?></td>
	</tr>
	<?php
	}
	?>
	</tbody>
</table>
<?php
//----------------------------------- additional paging -----------------------------
$jmldata=mssql_num_rows(mssql_query($QueMain));
$jmlhal=ceil($jmldata/100);


$page   = intval($_GET['page']);
$tpages = ($_GET['tpages']) ? intval($_GET['tpages']) : $jmlhal; 
$adjacents  = intval($_GET['adjacents']);

if($page<=0)  $page  = 1;
if($adjacents<=0) $adjacents = 4;

$url2 	= "mid=reslaparsip&kd_kategori=".$kd_kategori."&kd_lokasi=".$kd_lokasi."&kd_rak=".$kd_rak."&kd_box=".$kd_box."&tgl_awal=".$tgl_awal."&tgl_akhir=".$tgl_akhir."&tpages=" . $tpages . "&amp;adjacents=" . $adjacents;
$urlEnc2 = $edc->encrypt($url2,true);

$reload = $_SERVER['PHP_SELF'] . "?".$urlEnc2;
	
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
