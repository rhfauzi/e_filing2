<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 
<script>
$(document).ready(function() {

	$("#update").click(function(){
		var	id_arsip	=	$("#id_arsip").val();
		var	scanNo		=	$("#scanNo").val();
		var	nm_arsip	=	$("#nm_arsip").val();
		var	keterangan	=	$("#keterangan").val();

		if(nm_arsip == ''){
			window.alert('Mohon untuk mengisi nama arsip');
		}else if(keterangan == ''){
			window.alert('Mohon untuk mengisi keterangan');
		}else{

			if(confirm('ANDA YAKIN INGIN MENYIMPAN DATA ?')){

				$.ajax({
					type: "POST",
					data: "act=editarsip&id_arsip="+id_arsip+"&scanNo="+scanNo+"&keterangan="+keterangan+"&nm_arsip="+nm_arsip,
					url: "execute/exc_program.php",
					success: function(data){

						window.location = 'main.php?'+data;
						//alert(data);
					}
				});
			}
		}
	});

});
</script>
<?php
if(!empty($isiParam1)){
	$SqlCek	=	mssql_query("SELECT top 1 a.nama_arsip,b.isi_index2,b.scanNo
								FROM arsip a,arsip_scan b 
								WHERE a.no_scan = b.scanNo
								AND a.id_arsip = '".$isiParam1."'");
	$show	=	mssql_fetch_assoc($SqlCek);
}
//------------------------------------------- ALERT MESSAGE ------------------------------------

//back to list
$url    = "mid=listarsip";
$urlEnc = $edc->encrypt($url,true);
//----------------------------

if($isiParam2 == '1'){
?>
	<div class="alert alert-success alert-dismissable">
		<a href='main.php?<?php echo $urlEnc; ?>'>
			<button type="button" class="close">×</button>
		</a>
		<strong>SUCCESS !</strong> Data berhasil dirubah. 
	</div>
<?php
}elseif($isiParam2 == '2'){
?>
	<div class="alert alert-danger alert-dismissable">
		<a href='main.php?<?php echo $urlEnc; ?>'>
			<button type="button" class="close">×</button>
		</a>
		<strong>DENIED !</strong> mohon maaf, Data gagal dirubah. Mungkin ada kesalahan system. Harap hubungi administrator
	</div>
<?php
}
//----------------------------------------------------------------------------------------------
?>
<br>

<div class="panel panel-default">
	<div class="panel-heading">Form Ubah Arsip
		<div style="float:right;">
				<a href='#' onclick='history.back()'><input class="btn btn-info btn-sm" type=button value='Data Arsip'></a>
		</div>
	</div>

<div class="panel-body">
<div class="row">
<div class="col-lg-12">

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp;Data Arsip <i class="fa fa-arrow-right"></i>&nbsp;Ubah </i></div><br>
<table width="100%" border="0px">
	<tr>
		
	</tr>
	<tr><td height="10px" colspan="3"><input type='hidden' name='id_arsip' id='id_arsip' value='<?php echo $isiParam1; ?>' ></td></tr>
	<tr>
		<td width='15%'>Nama Arsip</td>
		<td width='30%'>
			<input type='text' class='form-control' name='nm_arsip' id='nm_arsip' value='<?php echo $show['nama_arsip']; ?>'>
		</td>
		<td></td>
	</tr>
	<tr><td height="10px" colspan="3"><input type='hidden' name='scanNo' id='scanNo' value='<?php echo $show['scanNo']; ?>' ></td></tr>
	<tr>
		<td>Keterangan</td>
		<td colspan='2'><textarea class='form-control' name='keterangan' id='keterangan'><?php echo $show['isi_index2']; ?></textarea></td>
	</tr>
	<tr><td height="30px" colspan="3"></td></tr>
	<tr>
		<td></td>
		<td colspan="2" align="right">
		<button id='update' class="btn btn-outline btn-warning">Update</button>
		<a href='#' onclick='history.back()'><input class="btn btn-defatult btn-sm" type=button value='Batal'></a>
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
		    <div class="panel-body">
		        <p style="font-size:12px">
		        	~ Form ubah box digunakan untuk merubah master box Arsip apabila ada kesalahan penulisan nama atau keterangan (<i>Human Error)</i>. <br>
		        </p>
		    </div>
		</div>
	</div>


