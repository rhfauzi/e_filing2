<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<?php
require 'function/seqno.php';
?>
<br>

<div class="panel panel-default">
<div class="panel-heading">Parameter Print Excel For QRCode Rak
	<div style="float:right;">
			<input class='btn btn-info btn-sm' type=button value='Kembali' onclick="window.history.back()">
	</div>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Utility <i class="fa fa-arrow-right"></i>&nbsp; Get Excel Rak</i></div><br>
<form name="form1" method="POST" action="report/downex.php?type=ex_qrrak&print=1&nm=Ex_QRRak">
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
		<td rowspan="5">
			<div class="col-lg-11" style="float: right;">
				<div class="panel panel-info">
				    <div class="panel-heading">
				        Informasi
				    </div>
				    <div class="panel-body" align="justify">
				        <p style="font-size:12px">
				        	~ <b>Parameter Print Excel For QRCode Rak </b>  ini digunakan untuk memilih data rak yang akan di download file excelnya dimana file excel tersebut terdapat kode atau link yang akan dirubah menjadi QRCode pada software pendukung pencetakan QRCode. <br><br>
				        	~ <b> Pilih Kode Lokasi </b> pada combo box Kode Lokasi untuk menentukan lokasi rak yang akan didownload data rak nya<br><br>
				        	~ <b>Klik BUtton Download Excel</b> yang berwarna hijau untuk mendapatkan file excel, jika anda telah memilih parameter sesuai kebutuhan.<br><br> 
				        </p>
				    </div>
				</div>
			</div>
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


