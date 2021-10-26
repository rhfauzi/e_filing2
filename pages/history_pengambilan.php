<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($param1 == 'alert')
{	
	if($isiParam1 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS !</strong> Data berhasil ubah. 
		</div>
	<?php
	}elseif($isiParam1 == '2'){
	?>
		<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>DENIED !</strong> mohon maaf, Data gagal diubah mungkin ada kesalahan system. harap hubungi administrator.
		</div>
	<?php
	}
}
//----------------------------------------------------------------------------------------------
?>

<h3>Data Histori Pengambilan Arsip</h3>
<div style="float:right;">

</div>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Pengambilan</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="DataPengambilan">
<thead>
	<tr>
		<th width="3%">No</th>
		<th width="10%">Kode Arsip</th>
		<th width="15%">Nama Pengambil</th>
		<th width="10%">Keperluan</th>
		<th width="10%">Tgl Ambil</th>
		<th width="10%">Tgl Kembali</th>
		<th width="5%">Status</th>
		<?php 
        if(in_array($level,$arr_group_editor)){ ?>
			<th width="10%">Aksi</th>
		<?php } ?>
	</tr>
</thead>
<tbody></tbody>
</table>

<div class="col-lg-13">
	<div class="panel panel-info">
	    <div class="panel-heading">
	        Informasi
	    </div>
	    <div class="panel-body" align="justify">
	        <p style="font-size:12px">
	        	~ <b>Daftar Arsip</b> digunakan untuk melihat data-data arsip yang ada.<br>
	        	~ 	<font style='color:green;'><b>L</b></font> = Lokasi,
					<font style='color:blue;'><b>R</b></font> = Rak,
					<font style='color:orange;'><b>B</b></font> = Box<br>
				~ klik button <input class="btn btn-outline btn-success btn-xs" type=button value='Ubah'> jika ingin merubah data arsip, yang akan menuju form ubah arsip.<br>
				~ Klik button <input class="btn btn-outline btn-danger btn-xs" type=button value='Hapus'> jika ingin menghapus data arsip.
				~ Button tersebut aktif sesuai akses level masing - masing user.
	        </p>
	    </div>
	</div>
</div>

</body>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
  <script>
	$(document).ready(function() {
            // Datepicker..
            $('.input-daterange input').each(function() {
                $(this).datepicker('clearDates');
            });

            var dataTable = $('#DataPengambilan').DataTable( {
                responsive: true,
                "order": [[ 0, "desc" ]],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    url :"pages/process_pengambilan.php", 
                    type: "post", 
                    
                    error: function(){  
                        $(".lookup-error").html("");
                        $("#DataPengambilan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#DataPengambilan_processing").css("display","none");
                    }
                }
            } ); 
           // end Datatable
        } );
	</script>
</html>
