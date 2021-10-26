<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

	$("#simpan").click(function(){
		var	kd_lokasi	=	$("#kd_lokasi").val();
		var	kd_rak		=	$("#kd_rak").val();

		if(kd_lokasi == '0'){
			window.alert('Mohon untuk memilih Kode Lokasi terlebih dahulu');
		}else if(kd_rak == '0'){
			window.alert('Mohon untuk memilih Kode Rak terlebih dahulu');
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=addbox&kd_rak="+kd_rak+"&kd_lokasi="+kd_lokasi,
					url: "execute/exc_master.php",
					success: function(data){
						 $("#kd_lokasi").val("0");
						 $("#kd_rak").val("0");

						 if(data ==''){
						 	window.location = 'main.php?mid=addbox&alert=1';
						 }else{
						 	window.location = 'main.php?mid=addbox&alert=2';
						 }
						 //alert(data);
					}
				});
			}
		}
	});



//--------------------COMBO BOX CHANGE VALUE----------------------------

	$("#kd_lokasi").change(function(){
	    var kd_lokasi = $("#kd_lokasi").val();
	    $.ajax({
	        url: "pages/procombox.php?act=kotak_rak",
	        data: "kd_lokasi=" + kd_lokasi,
	        success: function(data){
	            // jika data sukses diambil dari server, tampilkan di <select id=kota>
	            $("#kd_rak").html(data);
	            //alert(data);
	        }
	    });
	});

});//end jquery document
</script>
<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($_GET['alert'] == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?mid=msbox'>
			<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil disimpan. 
	</div>
<?php
}elseif($_GET['alert'] == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?mid=msbox'>
			<button type="button" class="close">×</button>
		</a>
		<strong>DENIED !</strong> mohon maaf, Data gagal disimpan.
	</div>
<?php
}
//----------------------------------------------------------------------------------------------
?>
<br>

<div class="panel panel-default">
<div class="panel-heading">Form Tambah Arsip (<i><b>step 1</b></i>)
	<div style="float:right;">
			<a href='main.php?mid=listarsip'><input class="btn btn-info btn-sm" type=button value='Data Arsip'></a>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Tambah Arsip</i></div><br>
<table width="100%" border="0px">
	<tr>
		<td width="25%">Kode Arsip</td>
		<td width="20%">
		<input type='text' id='kd_arip'  name="kd_arsip" placeholder="Cth : A001" readonly class="form-control ukuran10">
		</td>
		<td>
		<i class="ket">&nbsp;*Kode unik terisi otomatis</i>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td width="25%">Kode Lokasi</td>
		<td colspan="2">
		<select id='kd_lokasi' name="kd_lokasi" class="form-control ukuran5">
		<option value='0'>~ Pilih Lokasi ~</option>
		<?php
		$sqllok = mssql_query("SELECT * FROM mslokasi WHERE data_status = 'A'");
		while($reslok = mssql_fetch_assoc($sqllok)){
			echo"
				<option value='".$reslok['kd_lokasi']."'>".$reslok['kd_lokasi']." - ".$reslok['lokasi']."</option>
			";
		}
		?>
		</select>
		</td>
	</tr>
	<tr><td height="50px" colspan="3"></td></tr>
	<tr>
		<td colspan="3">
		<div id="kd_rak">
			<?php
				
				$kd_lokasi = $_GET['kd_lokasi'];


				// 			//-------------- variabel for paging-----------
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
				<?php } ?>
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="3">
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
					
				// 	$prevlabel = "&lsaquo; Prev";
				// 	$nextlabel = "Next &rsaquo;";
					
				// 	$out = "<div class=\"pagin\">\n";
					
				// 	// previous
				// 	if($page==1) {
				// 		$out.= "<span class='page active'>" . $prevlabel . "</span>\n";
				// 	}
				// 	elseif($page==2) {
				// 		$out.= "<a class='page gradient' href=\"" . $reload . "\">" . $prevlabel . "</a>\n";
				// 	}
				// 	else {
				// 		$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . ($page-1) . "\">" . $prevlabel . "</a>\n";
				// 	}
					
				// 	// first
				// 	if($page>($adjacents+1)) {
				// 		$out.= "<a class='page gradient' href=\"" . $reload . "\">1</a>\n";
				// 	}
					
				// 	// interval
				// 	if($page>($adjacents+2)) {
				// 		$out.= "...\n";
				// 	}
					
				// 	// pages
				// 	$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
				// 	$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
				// 	for($i=$pmin; $i<=$pmax; $i++) {
				// 		if($i==$page) {
				// 			$out.= "<span class=\"page active\">" . $i . "</span>\n";
				// 		}
				// 		elseif($i==1) {
				// 			$out.= "<a class='page gradient' href=\"" . $reload . "\">" . $i . "</a>\n";
				// 		}
				// 		else {
				// 			$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a>\n";
				// 		}
				// 	}
					
				// 	// interval
				// 	if($page<($tpages-$adjacents-1)) {
				// 		$out.= "...\n";
				// 	}
					
				// 	// last
				// 	if($page<($tpages-$adjacents)) {
				// 		$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $tpages . "</a>\n";
				// 	}
					
				// 	// next
				// 	if($page<$tpages) {
				// 		$out.= "<a class='page gradient' href=\"" . $reload . "&amp;page=" . ($page+1) . "\">" . $nextlabel . "</a>\n";
				// 	}
				// 	else {
				// 		$out.= "<span class='page active'>" . $nextlabel . "</span>\n";
				// 	}
				// 	echo "<div class='page gradient' style='float:right;'>Total ".$jmldata."</div>";
				// 	$out.= "</div>";

					
				// 	echo $out;

				// 	//-------------------------------------------------------------------------------------------
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
	        	~ <b>Form Tambah Arsip</b> digunakan untuk menambahkan data arsip.<br>
	        	~ Pilih lokasi penyimpanan terlebih dahulu (tentukan lokasi,rak dan box) sebelum memasuki form isian kelengkapan data arsip.<br>
	        	~ Pilih <b>Kode Lokasi</b> Maka akan muncul pilihan Rak sesuai dengan lokasi yang telah dipilih.<br>
	        	~ Setelah muncul kotak biru dengan beberapa pilihan <b> Kode Rak</b> pilih dan klik kotak tersebut untuk menuju ke halaman selanjutnya yaitu menentukan Box pada rak yang telah dipilih.<br>
	        	~ Mohon input data box pada menu master box terlebih dahulu ditujukan untuk <b>rak yang jumlah boxnya 0 / yang tidak dapat dipilih (disabled) </b>agar terdapat pilihan box untuk memasukan arsip pada rak yang telah ditentukan

	        </p>
	    </div>
	</div>
	</div>

