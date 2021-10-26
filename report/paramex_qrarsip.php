<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<script>
$(document).ready(function() {

$('#kd_rak').attr("disabled",true);
$('#kd_box').attr("disabled",true);

//--------------------COMBO BOX CHANGE VALUE----------------------------

	$("#kd_lokasi").change(function(){
	    var kd_lokasi = $("#kd_lokasi").val();
	    var kd_rak 	  = $("#kd_rak").val();
	    $.ajax({
	        url: "report/combo_param.php?act=lokrak",
	        data: "kd_lokasi=" + kd_lokasi,
	        success: function(data){
	            // jika data sukses diambil dari server, tampilkan di <select id=kota>
	            $("#kd_rak").html(data);
	            $('#kd_rak').attr("disabled",false);
	            //alert(data);
	        }
	    });

	    $.ajax({
	        url: "report/combo_param.php?act=rakbox",
	        data: "kd_rak=" + kd_rak,
	        success: function(data){
	            // jika data sukses diambil dari server, tampilkan di <select id=kota>
	            $("#kd_box").html(data);
	            $('#kd_box').attr("disabled",true);
	            //alert(data);
	        }
	    });

	});

	$("#kd_rak").change(function(){
	    var kd_rak = $("#kd_rak").val();
	    $.ajax({
	        url: "report/combo_param.php?act=rakbox",
	        data: "kd_rak=" + kd_rak,
	        success: function(data){
	            // jika data sukses diambil dari server, tampilkan di <select id=kota>
	            $("#kd_box").html(data);
	            $('#kd_box').attr("disabled",false);
	            //alert(data);
	        }
	    });
	});

});//end jquery document
</script>
<br>

<div class="panel panel-default">
<div class="panel-heading">Parameter Print Excel For QRCode Arsip
	<div style="float:right;">
			<input class='btn btn-info btn-sm' type=button value='Kembali' onclick="window.history.back()">
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Utility <i class="fa fa-arrow-right"></i>&nbsp; Get Excel Arsip</i></div><br>
<form name="form1" method="POST" action="report/downex.php?type=ex_qrarsip&print=1&nm=Ex_QRArsip">
<table width="100%" border="0px">
	<tr>
		<td width="15%">Kode Lokasi</td>
		<td colspan="2" width="30%">
		<select id='kd_lokasi' name="kd_lokasi" class="form-control ukuran10">
		<option value='0'>ALL</option>
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
		<td rowspan="7">
			<div class="col-lg-11" style="float: right;">
				<div class="panel panel-info">
				    <div class="panel-heading">
				        Informasi
				    </div>
				    <div class="panel-body" align="justify">
				        <p style="font-size:12px">
				        	~ <b>Parameter Print Excel For QRCode Arsip </b>  ini digunakan untuk memilih data box yang akan di download file excelnya dimana file excel tersebut terdapat kode atau link yang akan dirubah menjadi QRCode pada software pendukung pencetakan QRCode. <br><br>
				        	~ <b> Pilih Kode Lokasi </b> terlebih dahulu pada combo box Kode Lokasi untuk menentukan lokasi arsip dan kemudian anda dapat memilih data Kode Rak sesuai dengan lokasi yang telah dipilih.<br><br>
				        	~ <b> Pilih Kode Rak </b> terlebih dahulu pada combo box Kode Rak untuk menentukan Rak arsip dan kemudian anda dapat memilih data Kode Box sesuai dengan Rak yang telah dipilih.<br><br>
				        	~ <b>Klik BUtton Download Excel</b> yang berwarna hijau untuk mendapatkan file excel, jika anda telah memilih parameter sesuai kebutuhan.<br><br> 
				        </p>
				    </div>
				</div>
			</div>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Kode Rak</td>
		<td colspan="2">
		<select id='kd_rak' name="kd_rak" class="form-control ukuran10">
		<option value='0'>ALL</option>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Kode Box</td>
		<td colspan="2">
		<select id='kd_box' name="kd_box" class="form-control ukuran10">
		<option value='0'>ALL</option>
		</select>
		</td>
	</tr>
	<tr><td height="30px" colspan="3"></td></tr>
	<tr>
		<td></td>
		<td style="vertical-align: top">
		<input type="submit" name="simpan" value="Download Excel" id='simpan' 
		style='width:100%;height:50px;background-image: url(images/excel.png);background-repeat: no-repeat;background-size:35px;background-position: 50px 5px;'  
		class="btn btn-outline btn-success">
		</td>
	</tr>
</table>
</form>
<br>
</div>
</div>
</div>
</div>


