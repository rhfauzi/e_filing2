<?php
require '../setting/koneksi.php';
require '../function/seqno.php';
require '../function/changeformat.php';
require('../function/encdec.php');
conDB('.','e_filing');
session_start();

$edc = new encdec();

$arr_group_auditor = array('7');
$arr_group_viewer = array('6');
$arr_group_editor = array('1','2','8');
$arr_group_master = array('1','8');


if($_POST['aksi']=='tampil'){

$keyword = $_POST['test'];
?>
	<table width="70%" border="0px">
		<tr>
		<td>
		<?php

			//-------------- variabel for paging-----------
			$halaman=$_GET['page'];
			if(empty($halaman)){
			$posisi=0;
			$halaman=1;
			$batas=10;
			}
			else{
				$batas =10;
				$posisi=($halaman - 1) * $batas;
				$batas=$batas * $halaman;
			}
			//---------------------------------------------

			if(in_array($level,$arr_group_editor)){
				$filterUkerSearch = " WHERE unitkerja = '".$kode_uker."'";
            }else{
				$filterUkerSearch = "";
			}

			$QueMain = "SELECT *,ROW_NUMBER() over (order by id_arsip desc) as row FROM
						(
						SELECT
						a.id_arsip,a.kd_arsip,a.kd_uker,a.nama_arsip,a.tgl_masuk,
						b.unitkerja,b.scanNo,b.index1,b.isi_index1,b.index2,b.isi_index2,b.index3,b.isi_index3
						FROM arsip a WITH(NOLOCK) 
						RIGHT JOIN arsip_scan b WITH(NOLOCK)
						ON a.no_scan = b.scanNo
						WHERE A.nama_arsip like '%".$keyword."%'
						UNION
						SELECT 
						a.id_arsip,a.kd_arsip,a.kd_uker,a.nama_arsip,a.tgl_masuk,
						b.unitkerja,b.scanNo,b.index1,b.isi_index1,b.index2,b.isi_index2,b.index3,b.isi_index3
						FROM arsip a WITH(NOLOCK) 
						RIGHT JOIN arsip_scan b WITH(NOLOCK)
						ON a.no_scan = b.scanNo
						WHERE b.fileContent like '%".$keyword."%'
						UNION
						SELECT 
						a.id_arsip,a.kd_arsip,a.kd_uker,a.nama_arsip,a.tgl_masuk,
						b.unitkerja,b.scanNo,b.index1,b.isi_index1,b.index2,b.isi_index2,b.index3,b.isi_index3
						FROM arsip a WITH(NOLOCK) 
						RIGHT JOIN arsip_scan b WITH(NOLOCK)
						ON a.no_scan = b.scanNo
						WHERE a.kd_arsip = '".$keyword."'
						UNION
						SELECT 
						a.id_arsip,a.kd_arsip,a.kd_uker,a.nama_arsip,a.tgl_masuk,
						b.unitkerja,b.scanNo,b.index1,b.isi_index1,b.index2,b.isi_index2,b.index3,b.isi_index3
						FROM arsip a WITH(NOLOCK) 
						RIGHT JOIN arsip_scan b WITH(NOLOCK)
						ON a.no_scan = b.scanNo
						WHERE a.no_scan = '".$keyword."'
						)AS z
						$filterUkerSearch";

			$QueRow     = "SELECT * FROM($QueMain) as x 
							WHERE row > $posisi and row <= $batas
							ORDER by x.id_arsip desc";

			$cekData = mssql_num_rows(mssql_query($QueMain));
			if($cekData > 0){

				$sqlcari = mssql_query($QueRow);

				while($res = mssql_fetch_assoc($sqlcari)){

					$urlFile 		= "mid=listarsip_detail&kd_arsip=".$res['kd_arsip'];
					$urlDetailFile 	= $edc->encrypt($urlFile,true);

					echo "<font style='color:#1a39b3;font-size:18px'><a href='main.php?".$urlDetailFile."' style='color:#1a39b3;'>".$res['row'].").Arsip Code : ".$res['kd_arsip']." | Scan No : ".$res['scanNo']." | ".$res['unitkerja']."</a></font>";
					echo "<br>";
					echo "<font style='color:#10702f;'>".$res['kd_uker']."-".$res['tgl_masuk']."</font>";
					echo "<br>";

					echo "<font style='color:#747454;'>".FPotongTeks($res['deskripsi'],200)."</font>";
					echo "<br>";

					echo "<font style='color:#747454;'><b>".$res['index1']."</b>, ".$res['isi_index1'].",</font>";
					echo "<font style='color:#747454;'><b>".$res['index2']."</b>, ".$res['isi_index2'].",</font>";
					echo "<font style='color:#747454;'><b>".$res['index3']."</b>, ".$res['isi_index3'].",</font>";
					echo "<font style='color:#747454;'><b>".$res['index4']."</b>, ".$res['isi_index4'].",</font>";
					echo "<font style='color:#747454;'><b>".$res['index5']."</b>, ".$res['isi_index5'].",</font>";
					echo "<font style='color:#747454;'><b>".$res['index6']."</b>, ".$res['isi_index6'].",</font>";
					echo "<font style='color:#747454;'><b>".$res['index7']."</b>, ".$res['isi_index7'].",</font>";
					echo "<font style='color:#747454;'><b>".$res['index8']."</b>, ".$res['isi_index8'].",</font>";
					echo "<font style='color:#747454;'><b>".$res['index9']."</b>, ".$res['isi_index9'].",</font>";
					echo "<font style='color:#747454;'><b>".$res['index10']."</b>, ".$res['isi_index10'].",</font>";

					echo "<br><br>";
				}
			}else{
				echo "<h3 style='color:#999;'>Pencarian dengan keyword <b>".$keyword."</b> Tidak ditemukan</h3><br><br>";
				echo "Disarankan dengan kata yang lebih unik :<br>";
				echo "<ul>
						<li>Berdasarkan no dokumen</li>
						<li>Berdasarkan perihal</li>
						<li>Berdarkan tanggal dokumen <b>dsb.</b></li>
					</ul>";

			}
		?>
		</td>
		</tr>
	</table>
<?php

$jmldata=mssql_num_rows(mssql_query($QueMain));
$jmlhal=ceil($jmldata/10);


$page   = intval($_GET['page']);
$tpages = ($_GET['tpages']) ? intval($_GET['tpages']) : $jmlhal; 
$adjacents  = intval($_GET['adjacents']);

if($page<=0)  $page  = 1;
if($adjacents<=0) $adjacents = 4;

$urlPage    = "mid=pencarian_arsip&keyword=".$keyword."&tpages=" . $tpages . "&amp;adjacents=" . $adjacents;
$urlPageEnc = $edc->encrypt($urlPage,true);

$reload = "main.php?".$urlPageEnc;
	
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

}





//----------- fungsi untuk membatasi jumlah karakter yang tampil-------
function Fstrip_html_tags( $text ) //Fungsi Untuk  mengatasi teks berformat
{
$search = array ("'<script[^>]*?>.*?</script>'si",
                 "'<[/!]*?[^<>]*?>'si",   
                 "'&(quot|#34);'i",  
                 "'&(amp|#38);'i", 
                 "'&(lt|#60);'i", 
                 "'&(gt|#62);'i", 
                 "'&(nbsp|#160);'i", 
                 "'&(iexcl|#161);'i", 
                 "'&(cent|#162);'i", 
                 "'&(pound|#163);'i", 
                 "'&(copy|#169);'i", 
                 "'&#(d+);'e");                 
 
$replace = array ("", 
                 "",  
                 "\"", 
                 "&", 
                 "<", 
                 ">", 
                 " ", 
                 chr(161), 
                 chr(162), 
                 chr(163), 
                 chr(169), 
                 "chr(\1)"); 
 
$text = preg_replace($search, $replace, $text);
 
    return ($text);
}
 
function FPotongTeks( $text, $limit ) //Fungsi Untuk Memotong Panjang
{
 
$text = Fstrip_html_tags($text);
if( strlen($text)>$limit )
  {
    $text = substr( $text,0,$limit );
    $text = substr( $text,0,-(strlen(strrchr($text,' '))) ); $text="$text";
  }
 
return $text;
}
//----------------function --------------------

?>