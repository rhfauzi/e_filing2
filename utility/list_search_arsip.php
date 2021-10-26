
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
	<!-- <link href="css/sb-admin-2.css" rel="stylesheet"> -->
</head>
<body>


<h3>Hasil Pencarian Data Arsip</h3>
<div style="float:right;">
<?php
if($level == '2'){
    $url    = "mid=advc_sch";$urlEnc = $edc->encrypt($url,true);
    echo "<a id='tambah' href='main.php?".$urlEnc."'><input class='btn btn-primary' type=button value='Parameter Search'></a>";
    echo "&nbsp";
}
?>
</div>

<div><i class="ketmenu">Utility <i class="fa fa-arrow-right"></i>&nbsp; Advanced Search</i></div><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="DataSearch"> 
	<thead> 
		<tr> 
			<th width="3%">No</th> 
			<th width="8%">Kode Arsip</th> 
            <th width="10%">Nama Arsip</th>
            <th width="10%">Kategori</th>
            <th width="5%"><font style='color:green;'>L</font></th>
            <th width="5%"><font style='color:blue;'>R</font></th>
            <th width="5%"><font style='color:orange;'>B</font></th>
            <th width="5%">Status</th>
		</tr> 
	</thead>
	<tbody></tbody>
	<!-- <tfoot> 
		<tr> 
            <th>No</th> 
            <th>Kode Arsip</th> 
            <th>Nama Arsip</th>
            <th width="10%">Kategori</th>
            <th width="5%"><font style='color:green;'>L</font></th>
            <th width="5%"><font style='color:blue;'>R</font></th>
            <th width="5%"><font style='color:orange;'>B</font></th>
            <th width="5%">Status</th>
            <?php //if($level == '1' || $level == '2'){?>
                <th width="10%">Aksi</th>
            <?php //} ?> 
        </tr>  
	</tfoot>  -->
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

<?php
$kd_kategori = $_POST['kd_kategori'];
$kd_uker     = $_POST['kd_uker'];
$kd_lokasi   = $_POST['kd_lokasi'];
$kd_rak      = $_POST['kd_rak'];
$kd_box      = $_POST['kd_box'];
$jns_tgl     = $_POST['jns_tgl'];
$tgl_awal    = DBDate($_POST['tgl_awal']);
$tgl_akhir   = DBDate($_POST['tgl_akhir']);
echo "<input type='hidden' name='kd_kategori' id='kd_kategori' value='".$kd_kategori."'>";
echo "<input type='hidden' name='kd_uker' id='kd_uker' value='".$kd_uker."'>";
echo "<input type='hidden' name='kd_lokasi' id='kd_lokasi' value='".$kd_lokasi."'>";
echo "<input type='hidden' name='kd_rak' id='kd_rak' value='".$kd_rak."'>";
echo "<input type='hidden' name='kd_box' id='kd_box' value='".$kd_box."'>";
echo "<input type='hidden' name='jns_tgl' id='jns_tgl' value='".$jns_tgl."'>";
echo "<input type='hidden' name='tgl_awal' id='tgl_awal' value='".$tgl_awal."'>";
echo "<input type='hidden' name='tgl_akhir' id='tgl_akhir' value='".$tgl_akhir."'>";
?>


</body>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script>
	$(document).ready(function() {
         var kd_kategori = $('#kd_kategori').val();
         var kd_uker     = $('#kd_uker').val();
         var kd_lokasi   = $('#kd_lokasi').val();
         var kd_rak      = $('#kd_rak').val();
         var kd_box      = $('#kd_box').val();
         var jns_tgl     = $('#jns_tgl').val();
         var tgl_awal    = $('#tgl_awal').val();
         var tgl_akhir   = $('#tgl_akhir').val();

            $('.input-daterange input').each(function() {
                $(this).datepicker('clearDates');
            });

            var dataTable = $('#DataSearch').DataTable( {
                responsive: true,
                "order": [[ 0, "desc" ]],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    url :"Utility/process_search_listarsip.php?kd_kategori="+kd_kategori+"&kd_uker="+kd_uker+"&kd_lokasi="+kd_lokasi+"&kd_rak="+kd_rak+"&kd_box="+kd_box+"&jns_tgl="+jns_tgl+"&tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir, 
                    type: "POST", 
                    
                    error: function(){  
                        $(".lookup-error").html("");
                        $("#DataSearch").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#DataSearch_processing").css("display","none");
                    }
                }
            } ); 
           // end Datatable
        } );
	</script>
</html>