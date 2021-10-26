<!-- ditambahkan jquery 1.4 disini karena kalau ditaruh di main gak jalan, gak tau kenapa -->
<script type="text/javascript" src="js/jquery-1.4.js"></script> 

<script>
$(document).ready(function() {

	$("#kd_rak").attr("disabled",true);
	$("#kd_rak2").attr("disabled",true);
	$("#kd_box").attr("disabled",true);
	$("#tgl_awal").attr("disabled",true);
	$("#tgl_akhir").attr("disabled",true);
	$("#tgl_awal").val("");
	//$("#tgl_awal").css('background-color', '#cccccc');
	$("#tgl_akhir").val("");
	//$("#tgl_akhir").css('background-color', '#cccccc');

	$('#only_lok').hide();
	$('#lok_rak').hide();
	$('#complete').hide();

	$("#label_type").change(function(){
		var label_type = $('#label_type').val();

		// jika pilih lokasi
		if(label_type == '1'){
			$('#only_lok').show();
			$('#lok_rak').hide();
			$('#complete').hide();
		}else if(label_type == '2'){ // jika rak
			$('#only_lok').hide();
			$('#lok_rak').show();
			$('#complete').hide();
		}else{ //jika box
			$('#only_lok').hide();
			$('#lok_rak').hide();
			$('#complete').show();
		}
	});


	//--------------------COMBO BOX CHANGE VALUE BOX----------------------------

	$("#kd_rak").change(function(){
		    var kd_rak = $("#kd_rak").val();
		    $.ajax({
		        url: "pages/procombox.php?act=box",
		        data: "kd_rak=" + kd_rak,
		        success: function(data){
		            // jika data sukses diambil dari server, tampilkan di <select id=kota>
		            $("#kd_box").attr("disabled",false);
		            $("#kd_box").html(data);
		            //alert(data);
		        }
		    });
	});


	$("#jns_tgl").change(function(){
	    var jns_tgl = $("#jns_tgl").val();

	    if(jns_tgl == 0){
	    	$("#tgl_awal").attr("disabled",true);
	    	$("#tgl_akhir").attr("disabled",true);
	    	$("#tgl_awal").val("");
			$("#tgl_awal").css('background-color', '#efefef');
			$("#tgl_akhir").val("");
			$("#tgl_akhir").css('background-color', '#efefef');
	    }else{
	    	$("#tgl_awal").attr("disabled",false);
	    	$("#tgl_akhir").attr("disabled",false);
	    	$("#tgl_awal").val("");
			$("#tgl_awal").css('background-color', '#fff8bc');
			$("#tgl_akhir").val("");
			$("#tgl_akhir").css('background-color', '#fff8bc');
	    }
            
    
	});

var year = (new Date()).getFullYear() + 10

	$("#tgl_awal").datepicker({
		dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year
	});

	$("#tgl_akhir").datepicker({
		dateFormat : "dd/mm/yy",changeMonth : true,changeYear  : true,yearRange	: '1900:' + year
	});
});

function showmodal1(){
    $("#myModal1").modal();
}

function showmodal2(){
    $("#myModal2").modal();
}

function showmodal3(){
    $("#myModal3").modal();
}

</script>

<br>

<div class="panel panel-default">
<div class="panel-heading">Print Label</div>
<div class="panel-body">
<div class="row">

<div class="col-lg-7">

<div><i class="ketmenu">Utility <i class="fa fa-arrow-right"></i>&nbsp; Advanced Search</i></div><br>

<form name="form1" method="POST" action="Utility/download_label.php" onsubmit="return validate(this)">
<center>
<table width="100%" border="0px">
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Label Untuk</td>
		<td>
		<select id='label_type' name="label_type" class="form-control ukuran8">
		<option value='0'> - Pilih Label - </option>
			<option value="1">LOKASI</option>
			<option value="2">RAK</option>
			<option value="3">BOX</option>

		</select>
		</td>
	</tr>
	<tr><td height="80px" colspan="3"></td></tr>
</table>

<table width="100%" border="0px" id='only_lok'>
	<tr>
		<td>Lokasi</td>
		<td>
		<input readonly type='text' id='kd_lokasi3' name='kd_lokasi3' class="form-control ukuran10" placeholder="Klik tombol disibelah kanan ->">
		</td>
		<td><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="showmodal1()">
		&nbsp;Click</a></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
</table>


<table width="100%" border="0px" id='lok_rak'>
	<tr>
		<td>Lokasi</td>
		<td>
		<input readonly type='text' id='kd_lokasi2' name='kd_lokasi2' class="form-control ukuran10" placeholder="Klik tombol disibelah kanan ->">
		</td>
		<td><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="showmodal2()">
		&nbsp;Click</a></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Rak</td>
		<td>
		<select id='kd_rak2' name="kd_rak2" class="form-control ukuran8">
		<option value='0'>Semua Rak</option>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
</table>


<table width="100%" border="0px" id='complete'>
	<tr>
		<td>Lokasi</td>
		<td>
		<input readonly type='text' id='kd_lokasi' name='kd_lokasi' class="form-control ukuran10" placeholder="Klik tombol disibelah kanan ->">
		</td>
		<td><a href="#" style="text-decoration: none; padding: 10px 8px 10px 0px;" onclick="showmodal3()">
		&nbsp;Click</a></td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Rak</td>
		<td>
		<select id='kd_rak' name="kd_rak" class="form-control ukuran8">
		<option value='0'>Semua Rak</option>
		</select>
		</td>
	</tr>
	<tr><td height="10px" colspan="3"></td></tr>
	<tr>
		<td>Box</td>
		<td>
		<select id='kd_box' name="kd_box" class="form-control ukuran8">
		<option value='0'>Semua Box</option>
		</select>
		</td>
	</tr>
</table>


<table width="100%" border="0px">
	<tr><td height="20px" colspan="3"></td></tr>
	<tr><td colspan="3" align="center"><input type="submit"  name="submit" value="Download" class="page gradient"></td></tr>
</table>
</center>
</form>
</div>

	<div class="col-lg-5">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body">
	        <p style="font-size:12px">
	        	<center><img src='images/print_label.png'></center><br>
	        	~ Fitur ini digunakan untuk mendownload label kode ke dalam document microsoft word yang kemudian akan di print<br><br>

	        </p>
	    </div>
	</div>
	</div>
</div>
</div>
</div>


<?php include "pop_up.php";?>