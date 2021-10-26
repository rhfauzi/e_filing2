<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

//--------------------COMBO BOX CHANGE VALUE----------------------------

	$("#kd_lokasi").change(function(){
	    var kd_lokasi = $("#kd_lokasi").val();
	    $.ajax({
	        url: "pages/procombox.php?act=pindah_kotak_box",
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

<br>
<div class="panel panel-default">
<div class="panel-heading">Form Tambah Data Pemindahan Box (<i><b>step 1</b></i>)
	<div style="float:right;">
		<?php
		$url1   = "mid=menupindah";$urlEnc1 = $edc->encrypt($url1,true);
		?>
		<a id='tambah' href='main.php?<?php echo $urlEnc1; ?>'><input class='btn btn-info btn-sm' type=button value='Menu Pemindahan'></a>
		<input class="btn btn-info btn-sm" type=button value='Kembali' onclick='window.history.back()'>
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pemindahan<i class="fa fa-arrow-right"></i>&nbsp; Pemindahan Box</i></div><br>
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
				
				$kd_lokasi = $isiParam1;

				$QueMain = "SELECT id_rak,kd_lokasi,kd_rak FROM msrak WHERE data_status = 'A' AND kd_lokasi = '".$kd_lokasi."'";

				$Query = mssql_query($QueMain);

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
				<?php } ?>
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="3">
				<?php

				
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
	        	~ <b>Form Tambah Data Pemindahan Rak</b> digunakan untuk menambahkan data arsip.<br>
	        	~ Pilih lokasi penyimpanan terlebih dahulu (tentukan lokasi) sebelum memasuki form selanjutnya.<br>
	        	~ Pilih <b>Kode Lokasi</b> Maka akan muncul pilihan Rak sesuai dengan lokasi yang telah dipilih.<br>
	        	~ Setelah muncul kotak biru dengan beberapa pilihan <b> Kode Rak</b> pilih dan klik kotak tersebut untuk menuju ke halaman selanjutnya yaitu pemindahan rak.
	        </p>
	    </div>
	</div>
	</div>

