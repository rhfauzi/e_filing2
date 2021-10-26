<?php 
include "../setting/koneksi.php";
include "../function/changeformat.php";

kon_db();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-Filing</title>
    <link href="../images/favicon.png" rel="shortcut icon">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- additional -->
    <link href="../dist/css/additional.css" rel="stylesheet">


    <!-- additional paging -->
    <link type="text/css" href="../dist/css/additional_paging.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

     <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


    <!-- untuk tanggal -->
    <script type="text/javascript" src="../js/ui.datepicker.js"></script>
    <script type="text/javascript" src="../js/ui.core.js"></script>
    <link type="text/css" href="../dist/css/base/ui.all.css" rel="stylesheet" />

</head>
<?php
// $id = $_GET['id'];
	$id ='R001';

	$total_ars =mssql_fetch_assoc(mssql_query("SELECT count(*) as total_ars 
												FROM arsip WHERE kd_box in 
												(select kd_box from msbox where kd_rak = '".$id."')"));


	$total_box = mssql_fetch_assoc(mssql_query("SELECT count(*) as total_box FROM msbox 
												WHERE kd_rak in (select kd_rak FROM msrak where kd_rak = '".$id."')"));


?>
<body>

<div  style="margin:10px;">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
<img src="../images/logo2.png" width="150px">
<div style="float:right;"><img src="../images/rcode_logo.png" width="50px"></div>

</nav>

<h3>Informasi Rak <?php echo "<b><i>'".$id."'</i></b>"; ?></h3>
<div><i class="ketmenu">QRCode Scan Result</i></div>

<table width="100%" class="table table">
<tbody>
	<tr><td><i>Total Box</i></td><td>:</td><td align="right"><?php echo $total_box['total_box']; ?></td></tr>
	<tr><td><i>Total Arsip</i></td><td>:</td><td align="right"><?php echo $total_ars['total_ars']; ?></td></tr>
</tbody>


<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
	<tr>
		<th width="5%">No</th>
		<th width="8%">Kode Box</th>
		<th width="15%">Jumlah Arsip</th>
	</tr>
</thead>
	<tbody>
	<?php
		
		$Query	=	mssql_query("SELECT row_number() over (order by id_box) as no, kd_box from msbox where kd_rak = '".$id."'");

		
		while($res	=	mssql_fetch_assoc($Query)){

		$jumars  = mssql_fetch_assoc(mssql_query("SELECT count(*) as jml_ars FROM arsip 
													WHERE kd_box in 
													(select kd_box from msbox where kd_box = '".$res['kd_box']."')"));

		?>
		<tr>
			<td><?php echo $res['no'];?></td>
			<td><?php echo $res['kd_box'];?></td>
			<td><?php echo $jumars['jml_ars']; ?></td>
				
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

</div>

 <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/jquery/jquery.js"></script>


    <!-- tambahan-->
    <script src="../function/validate.js"></script>


    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
 <!--    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.js"></script> -->

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script src="../js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>



    <script>
    $(document).ready(function() {
        $("#dataTables-example").DataTable({
            responsive: true,
             ordering: false,
             searching :false,
             info:false,
             lengthChange :false
        });
    });

    </script>
    

     </body>
   </html>