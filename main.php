<?php

error_reporting(0);
session_start();

include "setting/koneksi.php";
include "function/changeformat.php";
include "function/info.php";
include "function/check.php";
require('function/encdec.php');


conDB('.','e_filing');
// session_start();
$userlogin =  $_SESSION['iduser'];
// $userlogin = '408';


if($userlogin == ''){
  header("location:../apps/auth");
}


$userInfo = infolog($userlogin);
$groupdesc  = $userInfo['groupdesc'];
$level      = $userInfo['group'];
$kodeunit   = $userInfo['KodeUnit'];
$unitkerja  = $userInfo['UnitKerja']; //AMBIL DARI SIMSDM
$kode_uker  = $userInfo['kode_uker']; //AMBIL DARI TABLE USERMENU
$nm_pegawai = $userInfo['nm_pegawai'];
$id_pegawai = $userInfo['id_pegawai'];

// echo "<br>groupdesc=".$groupdesc;
// echo "<br>level=".$level;
// echo "<br>kodeunit=".$kodeunit;
// echo "<br>unitkerja=".$unitkerja;//AMBIL DARI SIMSDM
// echo "<br>kode_uker=".$kode_uker; //AMBIL DARI TABLE USERMENU
// echo "<br>nm_pegawai=".$nm_pegawai;
// echo "<br>id_pegawai=".$id_pegawai;

// 1 = superAdmin, 2 = pic , 3 = approver spv, 4 = aprover manager, 5= approver GM, 6 = viewer , 7 =audit,8 = pic plus
$arr_group_auditor = array('7');
$arr_group_viewer = array('6');
$arr_group_editor = array('1','2','8');
$arr_group_master = array('1','8');

$uker  = tb_unitkerja();

//------    package query -------
$func_que_arsip     = mainque_tbarsip();
$func_que_box       = mainque_tbbox();
$func_count_arsip   = countque_tbarsip();
$func_count_box     = countque_tbbox();
//-------------------------------------

//echo "session=".$_SESSION['iduser'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BRINSAVE</title>
    <link href="images/favicon.png" rel="shortcut icon">

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- additional -->
    <link href="dist/css/additional.css" rel="stylesheet">


    <!-- additional paging -->
    <link type="text/css" href="dist/css/additional_paging.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

     <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


    <!-- untuk tanggal -->
    <link type="text/css" href="dist/css/base/ui.all.css" rel="stylesheet" />



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="js/jquery-1.4.js" type="text/javascript" ></script>
    <style type="text/css">
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('images/loading_fish.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
    }

    .navbar-static-top{
        position: fixed;
        z-index: 1000;
        width: 100%;
    }
</style>

    <script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut("slow");
    });
    </script>

</head>
    <body>
        <div class="loader"></div>
        <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <?php
            include'layout/header.php'; // Header
            include'layout/sidemenu.php';   // Menu Sidebar
          ?>
          </nav>

            <div id="page-wrapper">
                <div class="row">
              <?php
                include'layout/content.php'; //content
              ?>   
                </div>
            </div>
            <?php
            include'layout/footer.php'; //footer
            ?>
            
        </div>

          
   <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/jquery/jquery.js"></script>

    <!-- for date -->
    <script type="text/javascript" src="js/ui.datepicker.js"></script>
    <script type="text/javascript" src="js/ui.core.js"></script>


    <!-- tambahan-->
    <script src="function/validate.js"></script>


    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
 <!--    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.js"></script> -->

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <script src="js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>



    <script>
    $(document).ready(function() {
        $("#dataTables-example").DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $("#dataTables-example2").DataTable({
            responsive: true
        });
    });
    </script>
    

     </body>
   </html>


