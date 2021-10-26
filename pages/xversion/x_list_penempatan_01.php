
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
	<!-- <link href="css/sb-admin-2.css" rel="stylesheet"> -->
</head>

<script>
$(document).ready(function() {

	$("#actBtn").attr('disabled',true);
	$("#actSelect").change(function(){
		var	actSelect = $("#actSelect").val();
		
		//jika select pilihan 'cek semua'
		if(actSelect == 1){
			$("#actBtn").attr('disabled',false);
            $(".locate_button").attr('disabled',true);
			$('input:checkbox').prop('checked',true);
		}else{
			//jika set pilihan 'uncek semua' maka pilihan kembali ke pilihan 'pilih'
			if(actSelect == 2){ 
				$('select').prop('selectedIndex',0);
			}
			$("#actBtn").attr('disabled',true);
            $(".locate_button").attr('disabled',false);
			$('input:checkbox').prop('checked',false);
		}
	});

	//jika ada cekbox yang tercentang maka button 'proses terpilih' enabled
	//sebaliknya jika tidak ada cekbox yang tercentang maka button 'proses terpilih' disabled
	// var ckbox = $('.ck');

    // $('input').on('click',function () {
    //     if (ckbox.is(':checked')) {
    //         $("#actBtn").attr('disabled',false);
    //         //$(".locate_button").attr('disabled',true);
    //     } else {
    //         $("#actBtn").attr('disabled',true);
    //         //$(".locate_button").attr('disabled',false);
    //     }
    // });


});
</script>
<body>
<br>
<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($param1 == 'alert')
{	
	if($isiParam1 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>SUCCESS !</strong> Data berhasil <?php echo $isiParam2; ?>. 
            Silakan Lihat pada menu 
            <?php
            $url    = "mid=listarsip";
            $urlEnc = $edc->encrypt($url,true);
            echo "<a href='main.php?".$urlEnc."'>Data Arsip</a>";
            ?>
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>DENIED !</strong> mohon maaf, Data gagal <?php echo $isiParam2; ?>. mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------
?>
<h3>Pengalokasian arsip</h3>
<h4 style="color: #777777;">Data hasil scan yang arsip fisiknya belum ditentukan tempatnya</h4>
<div style="float:right;">
</div>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pengalokasian</i></div><br>
<?php
    $url = "main.php?mid=formlok&scanNo=S0011130820180144";
    $urlEnc = $edc->encrypt($url,true);
?>
<form name="form_scan" method="post" action="<?php echo $urlEnc;?>" enctype='multipart/form-data'>
<table width="100%" class="table table-striped table-bordered table-hover" id="DataScan"> 
	<thead> 
    <tr>
		<td colspan="8">
			<table border="0px" width="100%">
			<tr>
				<td width='8%'>action check</td><td align="center">:</td>
				<td width="63%">
				<select class="form-control" id='actSelect'>
					<option value='0'>-Pilih-</option>
					<option value='1'>Check Semua</option>
					<option value='2'>UnCheck Semua</option>
				</select>
				</td>
				<td width="10%"></td>
				<td width="13%" align="right">
					<input class="btn btn-primary" type=submit title='proses ini akan mengeksekusi data yang terceklist' value='Proses Terpilih' id='actBtn' name="actBtn">
				</td>
			</tr>
		</table>
		</td>
	</tr>
		<tr> 
			<th width="3%">No</th> 
			<th width="8%">No Scan</th>
            <th width="10%">Nama File</th>
            <th width="8%">Jml Hal</th>
            <th width="10%">Tgl Scan</th>   
            <?php if($level == '1' || $level == '2'){?>
                <th width="10%">Aksi</th>
            <?php } ?> 
		</tr> 
	</thead>
	<tbody></tbody>
</table>
</form>

<div class="col-lg-13">
    <div class="panel panel-info">
        <div class="panel-heading">
            Informasi
        </div>
        <div class="panel-body" align="justify">
            <p style="font-size:12px">
                ~ <b>Daftar Penempatan</b> digunakan untuk melihat data-data arsip yang sudah diupload softcopynya namun hardcopynya belum ditempatkan
                <br>~ klik button <input class="btn btn-outline btn-success btn-xs" type=button value='Alokasi'> jika ingin menentukan lokasi hardcopy dari arsip.<br>
            </p>
        </div>
    </div>
</div>


</body>

<!-- <script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script> -->
  <script>
	$(document).ready(function() {
            // Datepicker..
            // $('.input-daterange input').each(function() {
            //     $(this).datepicker('clearDates');
            // });

            var dataTable = $('#DataScan').DataTable( {
                responsive: true,
                "order": [[ 0, "desc" ]],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    url :"pages/process_listpenempatan.php", 
                    type: "post", 
                    
                    error: function(){  
                        $(".lookup-error").html("");
                        $("#DataScan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#DataScan_processing").css("display","none");
                    }
                }
            } ); 
           // end Datatable
        } );
	</script>
</html>