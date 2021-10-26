<?php
/* Database connection start */
    session_start();
    set_time_limit(0);
    
    include "../setting/koneksi.php";
    conDB('.','e_filing');
    /* Database connection end */


    $userlogin =  $_SESSION['iduser'];

    include "../function/info.php";
    include "../function/check.php";
    include "../function/encdec.php";
    $userlogin =  $_SESSION['iduser'];
    $userInfo = infolog($userlogin);
    $level    = $userInfo['group'];
    $edc = new encdec();


// storing  request (ie, get/post) global array to a variable  
$requestData = $_POST;

$func_que_arsip     = mainque_tbarsip();


$columns = array( 
    0 => 'ScanNo'
    //7 => 'query'  
);



$start      = $requestData['start'];
$length     = $requestData['length'];


$sql = "SELECT count(ScanNo) as jml_data FROM arsip_scan 
            WHERE scanNo not in (select no_scan from arsip where no_scan is not null)";

$query          = mssql_query($sql) or die("process_listpenempatan.php: get InventoryItems");
$res            = mssql_fetch_array($query);
$totalData      = $res['jml_data'];
$totalFiltered  = $totalData; 


if( !empty($requestData['search']['value'])) {
    // if there is a search parameter

    $sql = "SELECT * FROM arsip_scan WHERE scanNo not in (select no_scan from arsip where no_scan is not null)
                AND (
                    ScanNo LIKE '%".$requestData['search']['value']."%'
                )
            ";

    $query = mssql_query($sql) or die("ajax-grid-data.php: get PO");
    $totalFiltered = mssql_num_rows($query);  
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";

    $query=mssql_query($sql) or die("process_listpenempatan.php: get InventoryItems"); 
    //echo $sql;


}else {

    $sql =  "SELECT * FROM arsip_scan where scanNo not in (select no_scan from arsip where no_scan is not null)";
    $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
    //echo $sql;
    $query=mssql_query($sql) or die("process_listpenempatan.php: get InventoryItems");
    
}
// $nomor=1;
$data = array();
$no = 1;

while( $res=mssql_fetch_array($query) ) {

    //jika yang login super admin dan admin/PIC
        
    $url    = "mid=formlok&scanNo=".$res['scanNo'];
    $urlEnc = $edc->encrypt($url,true); 
    $located  = "<a style='text-decoration:none;' href='main.php?".$urlEnc."'>
    <input class='btn btn-outline btn-success btn-xs locate_button'  type=button value='ALOKASIKAN'></a>";

    $cekBox = "<div style='float:right'>
                <label class='ckbox'>
                <input type='checkbox' name='chk_$no' id='chk_od$no' class='ck' value='1'>
                <span class='checkmark'></span>
                </label>
                <input type='hidden' name='jml[]'></div>";
        
    $nomor        = $no." ".$cekBox;
    $scanNo       = $res['scanNo'];
    $urlDetail    = "mid=preview_scan&scanNo=".$res['scanNo'];
    $urlDetailEnc = $edc->encrypt($urlDetail,true);
    $docFileName  = "<a href='main.php?".$urlDetailEnc."'><img src='images/detail.png' width='5%' height='20%'> ".$res['docFileName']."</a>";
    $docPageCount = $res['docPageCount'];
    $createdDate  = $res['createdDate'];
    $aksi         = $located;

    $nestedData     = array(); 
    $nestedData[]   = $nomor;
    $nestedData[]   = $scanNo;
    $nestedData[]   = $docFileName;
    $nestedData[]   = $docPageCount;
    $nestedData[]   = $createdDate;
    $nestedData[]   = $aksi;
    
    $data[] = $nestedData;

    $no++;

    
}


$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   
            "recordsTotal"    => intval( $totalData ),  
            "recordsFiltered" => intval( $totalFiltered ), 
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format

?>
