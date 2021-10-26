<?php
/* Database connection start */

    include "../setting/koneksi.php";
    conDB('.','e_filing');
    /* Database connection end */

$label_type = $_POST['label_type'];

$kd_lokasi3 = $_POST['kd_lokasi3'];

$kd_lokasi2 = $_POST['kd_lokasi2'];
$kd_rak2 	= $_POST['kd_rak2'];

$kd_lokasi 	= $_POST['kd_lokasi'];
$kd_rak 	= $_POST['kd_rak'];
$kd_box 	= $_POST['kd_box'];

// $kd_lokasi 	= "L002";
// $kd_rak 	= "R002";
// $kd_box 	= "";

// jika yang ingin di print adalah kode lokasi
if($label_type == '1')
{
	if($kd_lokasi3 == '' || $kd_lokasi3 == '0'){
		$filter = "";
	}else{
		$filter = " WHERE kd_lokasi ='".$kd_lokasi3."'";
	}

	$sql_label = mssql_query("SELECT * FROM mslokasi ".$filter."");
}

// jika yang ingin di print adalah kode rak
elseif($label_type == '2')
{
	if($kd_lokasi2 == '' || $kd_lokasi2 == '0'){
		$filter = "";
	}else{
		if($kd_rak2 == '' || $kd_rak2 == '0'){
			$filter = " WHERE kd_lokasi ='".$kd_lokasi2."'";
		}else{
			$filter = " WHERE kd_lokasi ='".$kd_lokasi2."' AND kd_rak ='".$kd_rak2."'";
		}
	}

	$sql_label = mssql_query("SELECT * FROM msrak ".$filter."");
}

// jika yang ingin di print adalah kode box
else{

	if($kd_lokasi == '' || $kd_lokasi == '0'){
		$filter = "";
	}else{
		if($kd_rak == '' || $kd_rak == '0'){
			$filter = " WHERE kd_rak in (select kd_rak from msrak where kd_lokasi = '".$kd_lokasi."')";
		}else{
			if($kd_box == '' || $kd_box == '0'){
				$filter = " WHERE kd_rak = '".$kd_rak."'";
			}else{
				$filter = " WHERE kd_box = '".$kd_box."'";
			}
		}
	}

	$sql_label = mssql_query("SELECT * FROM msbox ".$filter."");

}


$sql_cek = mssql_num_rows($sql_label);

if($sql_cek == nulll || $sql_cek == 0 || $sql_cek == ''){
		echo"<script type=text/javascript>alert('Data Tidak ada')
				 window.close()</script>";
}
else{
	include "collectiontype.php"; ?>
	 
	 <html>
	 <head>
	<style>        
	@page Section1 {size:595.45pt 841.7pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	        div.Section1 {page:Section1;}
	        @page Section2 {size:841.7pt 595.45pt;mso-page-orientation:landscape;margin:1.25in 1.0in 1.25in 1.0in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	        div.Section2 {page:Section2;}

	</style>
	</head>
		<body>
	
	<?php
	$no =1;
	while($sqlshow = mssql_fetch_assoc($sql_label))
	{ ?>
		<div class=Section2>
		 <font style='font-size:300px;padding-left:50px;font-family:sans-serif;'><b>
		 	<?php 
		 	if($label_type == '1'){
		 		echo $sqlshow['kd_lokasi'];
		 	}else if($label_type == '2'){
		 		echo $sqlshow['kd_rak'];
		 	}else{
		 		echo $sqlshow['kd_box']; 
		 	}
		 	
		 	?> </b></font><br>
		</div>
	<?php 
	}?>

	</body>
		</html>
<?php
}
?>