
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
	<!-- <link href="css/sb-admin-2.css" rel="stylesheet"> -->
</head>
<body>

<?php
//------------------------------------------- ALERT MESSAGE ------------------------------------	
if($param1 == 'alert')
{	
	if($isiParam1 == '1'){
	?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>SUCCESS !</strong> Data berhasil <?php echo $isiParam2; ?>. 
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
<h3>Data Arsip</h3>
<h4 style="color: #777777;">Data arsip yang sudah teralokasi</h4>
<div style="float:right;">
<?php
// jika yang login super admin dan admin
// if(in_array($level,$arr_group_editor)){
//     echo "<a id='tambah' href='main.php?mid=addarsip'><input class='btn btn-primary' type=button value='Tambah Arsip'></a>";
//     echo "&nbsp";
// }
?>
</div>

<div><i class="ketmenu">Management <i class="fa fa-arrow-right"></i>&nbsp; Daftar Arsip</i></div><br>

<table width="100%" class="table table-striped table-bordered table-hover" id="DataArsip"> 
	<thead> 
		<tr class="softblue"> 
			<th width="3%">No</th> 
			<th width="15%">Kode / Nama Arsip</th> 
            <th width="15%">(kategori) Keterangan</th>
            <th width="15%">Unitkerja</th>
            <?php
            if(!in_array($level,$arr_group_viewer)){
            ?>
            <th width="5%"><font style='color:green;'>L |</font></th>
            <th width="5%"><font style='color:blue;'>R |</font></th>
            <th width="5%"><font style='color:orange;'>B</font></th>
            <?php 
            }
            ?> 
            <th width="5%">Status</th>
            <?php
            if(in_array($level,$arr_group_master)){
            ?>
                <th width="10%">Aksi</th>
            <?php 
            }
            ?> 
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
                ~   <font style='color:green;'><b>L</b></font> = Lokasi,
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
            // $('.input-daterange input').each(function() {
            //     $(this).datepicker('clearDates');
            // });

            var dataTable = $('#DataArsip').DataTable( {
                responsive: true,
                "order": [[ 0, "desc" ]],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    url :"pages/process_listarsip.php", 
                    type: "post", 
                    
                    error: function(){  
                        $(".lookup-error").html("");
                        $("#DataArsip").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#DataArsip_processing").css("display","none");
                    }
                }
            } ); 
           // end Datatable
        } );
	</script>
</html>